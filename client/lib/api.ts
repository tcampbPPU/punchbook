import { FetchError, FetchOptions, SearchParams } from 'ohmyfetch'
import { reactive, ref } from '@vue/reactivity'
import { IncomingMessage, ServerResponse } from 'http'
import { useCookie } from 'h3'
import { TailvueToast } from 'tailvue'
import { Router } from 'vue-router'

export interface UserLogin {
  token: string
  user: models.User
  provider: string
  error?: string
}

export interface AuthConfig {
  fetchOptions: FetchOptions
  req?: IncomingMessage
  res?: ServerResponse
  redirect: {
    logout: string
    login: undefined|string
  }
}

const authConfigDefaults:AuthConfig = {
  fetchOptions: {},
  req: undefined,
  res: undefined,
  redirect: {
    logout: '/',
    login: undefined,
  },
}

export default class Api {

  private token = ref<string|undefined>(undefined)
  public config: AuthConfig
  public $user = reactive<models.User|Record<string, unknown>>({})
  public $toast:TailvueToast
  public loggedIn = ref(false)

  constructor(config: AuthConfig, toast: TailvueToast) {
    this.$toast = toast
    this.config = { ...authConfigDefaults,...config }
  }

  async checkUser() {
    this.token.value = this.getToken()
    console.log(this.token.value);
    if (this.token.value)  {
      this.loggedIn.value = true
      await this.setUser()
    }
  }

  async login (result: UserLogin): Promise<undefined|string> {
    this.loggedIn.value = true
    this.token.value = result.token
    this.$user = reactive(result.user)
    return this.config.redirect.login
  }

  private getToken(): string {
    console.log(this.config.req)
    if (this.config.req) return useCookie(this.config.req, 'auth.token')
    return `; ${document.cookie}`.split(`; auth.token=`).pop().split(';').shift()
  }

  private fetchOptions(params?: SearchParams, method = 'GET'): FetchOptions {
    const fetchOptions = this.config.fetchOptions
    fetchOptions.headers = {
      Accept: 'application/json',
      Authorization: `Bearer ${this.token.value}`,
    }
    fetchOptions.method = method
    delete this.config.fetchOptions.body
    delete this.config.fetchOptions.params
    if (params)
      if (method === 'POST' || method === 'PUT')
        this.config.fetchOptions.body = params
      else
        this.config.fetchOptions.params = params
    return this.config.fetchOptions
  }

  private async setUser(): Promise<void> {
    try {
      const result = await $fetch<api.MetApiResponse & { data: models.User }>('/me', this.fetchOptions())
      this.$user = reactive(result.data)
    } catch (e) {
      await this.invalidate()
    }
  }

  public async index <Results>(endpoint: string, params?: SearchParams): Promise<api.MetApiResults & { data: Results }> {
    try {
      return await $fetch<api.MetApiResults & { data: Results }>(endpoint, this.fetchOptions(params))
    } catch (error) {
      await this.toastError(error)
    }
  }

  public async get <Result>(endpoint: string, params?: SearchParams): Promise<api.MetApiResponse & { data: Result }> {
    try {
      return await $fetch<api.MetApiResponse & { data: Result }>(endpoint, this.fetchOptions(params))
    } catch (error) {
      await this.toastError(error)
    }
  }

  public async update (endpoint: string, params?: SearchParams): Promise<api.MetApiResponse> {
    try {
      return (await $fetch<api.MetApiResults & { data: api.MetApiResponse}>(endpoint, this.fetchOptions(params, 'PUT'))).data
    } catch (error) {
      await this.toastError(error)
    }
  }

  public async store (endpoint: string, params?: SearchParams): Promise<api.MetApiResponse> {
    try {
      return (await $fetch<api.MetApiResults & { data: api.MetApiResponse}>(endpoint, this.fetchOptions(params, 'POST'))).data
    } catch (error) {
      await this.toastError(error)
    }
  }

  public async delete (endpoint: string, params?: SearchParams): Promise<api.MetApiResponse> {
    try {
      return (await $fetch<api.MetApiResults & { data: api.MetApiResponse}>(endpoint, this.fetchOptions(params, 'DELETE'))).data
    } catch (error) {
      await this.toastError(error)
    }
  }

  private async toastError (error: FetchError): Promise<void> {
    if (error.response?.data && error.response.data.errors)
      for (const err of error.response.data.errors)
        this.$toast.show({
          type: 'danger',
          message: err.detail ?? err.message ?? '',
          timeout: 0,
        })
    if (error.response?.status === 401)
      return await this.invalidate()

    if (error.response?.status === 403)
      return this.$toast.show({
        type: 'denied',
        message: error.response.data.message,
        timeout: 0,
      })

    if (error.response?.data.exception)
      this.$toast.show({
        type: 'danger',
        message: `<b>[${error.response.data.exception}]</b> <br /> ${error.response.data.message} <br /> <a href="phpstorm://open?file=/${error.response.data.file}&line=${error.response.data.line}">${error.response.data.file}:${error.response.data.line}</a>`,
        timeout: 0,
      })
  }


  public async logout (router: Router): Promise<void> {
    const response = (await $fetch<api.MetApiResults>('/logout', this.fetchOptions()))
    this.$toast.show(response.data)
    await this.invalidate(router)
  }

  private async invalidate (router?: Router): Promise<void> {
    this.token.value = undefined
    this.loggedIn.value = false
    this.$user = undefined
    if (!this.config.req) document.cookie = 'token=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    if (router) await router.push(this.config.redirect.logout)
    else if (!this.config.req) document.location = this.config.redirect.logout
  }

}
