<script lang="ts" setup>
import { useRouter } from 'vue-router'
import { Icon } from '@iconify/vue'
import { PushButton } from 'tailvue'
import { onBeforeUnmount, onMounted, reactive, ref } from 'vue'
import type { UserLogin } from '~/lib/api'

const emit = defineEmits(['off'])
const config = useRuntimeConfig()
const router = useRouter()
const { $toast, $api } = useNuxtApp()
const email = ref('')
const loading = reactive({
  attempt: false,
  google: false,
} as Record<string, boolean>)

const off = () => emit('off')

async function attempt(): Promise<void> {
  loading.attempt = true
  const result = await $api.store('/attempt', { email: email.value })
  loading.attempt = false
  if (!result)
    return
  $toast.show({
    type: 'success',
    title: 'Login E-mail Sent',
    message: `Login link sent to <b>${email.value}</b>`,
    timeout: 5,
  })
  email.value = ''
  emit('off')
}

function messageHandler(add: boolean): void {
  if (add)
    return window.addEventListener('message', handleMessage)
  return window.removeEventListener('message', handleMessage)
}

const oauthComplete = async (result: UserLogin): Promise<void> => {
  loading[result.provider] = false
  const redirect = await $api.login(result)
  if (redirect)
    await router.push({ path: redirect })
  emit('off')
}

function handleMessage(event: { data: UserLogin }): void {
  if (event.data.user && event.data.token)
    oauthComplete(event.data)
  if (event.data.error)
    $toast.show({ type: 'danger', message: event.data.error })
}

function login(provider: 'github' | 'google'): void {
  loading[provider] = true
  const width = 640
  const height = 660
  const left = window.screen.width / 2 - width / 2
  const top = window.screen.height / 2 - height / 2
  const win = window.open(
    `${config.apiURL}/redirect/${provider}`,
    'Log In',
    `toolbar=no, location=no, directories=no, status=no, menubar=no, scollbars=no,
      resizable=no, copyhistory=no, width=${width},height=${height},top=${top},left=${left}`,
  )
  const interval = setInterval(() => {
    if (win === null || win.closed) {
      clearInterval(interval)
      loading[provider] = false
    }
  }, 200)
}

onMounted(() => {
  if (window)
    messageHandler(true)
})
onBeforeUnmount(() => {
  if (window)
    messageHandler(false)
})
</script>

<template>
  <div class="px-4 py-4 bg-white dark:bg-gray-800 sm:px-10">
    <img
      class="w-auto h-12 pb-4 mx-auto"
      src="/punchlist-logo-dark-1.svg"
      alt="PunchBook"
    />
    <div class="grid grid-cols-2 gap-3">
      <div>
        <PushButton class="justify-center w-full" @click="login('google')">
          <Icon
            v-if="loading.google"
            icon="gg:spinner-two"
            class="w-6 h-6 text-indigo-600 animate-spin"
          />
          <Icon v-else icon="flat-color-icons:google" class="w-6 h-6" />
        </PushButton>
      </div>
      <div>
        <PushButton class="justify-center w-full" @click="login('github')">
          <Icon
            v-if="loading.github"
            icon="gg:spinner-two"
            class="w-6 h-6 text-indigo-600 animate-spin"
          />
          <Icon v-else icon="mdi-github" class="w-6 h-6" />
        </PushButton>
      </div>
    </div>
    <div class="relative mt-6">
      <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
      </div>
      <div class="relative flex justify-center text-sm leading-5">
        <span class="px-2 text-gray-500 bg-white dark:bg-gray-800">
          Or continue with
        </span>
      </div>
    </div>
    <label
      class="block mt-6 text-sm font-medium leading-5 text-gray-700 dark:text-gray-500"
      for="login_email"
    >Email address</label>
    <div class="relative mt-1 rounded-md shadow-sm">
      <div
        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
      >
        <Icon icon="mdi:envelope" class="w-5 h-5 text-gray-400" />
      </div>
      <input
        id="login_email"
        ref="input"
        v-model="email"
        class="block w-full px-3 py-2 pl-10 placeholder-gray-400 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none form-input dark:bg-gray-600 dark:border-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
        :readonly="loading.attempt"
        placeholder="email@address.com"
        type="email"
        @keydown.esc="off"
        @keydown.enter="attempt"
      />
    </div>
    <div class="mt-6">
      <span class="block w-full rounded-md shadow-sm">
        <PushButton
          theme="indigo"
          class="justify-center w-full"
          @click="attempt"
        >
          Sign in / Register
          <div
            v-if="loading.attempt"
            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
          >
            <Icon
              icon="gg:spinner-two"
              class="w-5 h-5 text-indigo-200 animate-spin"
            />
          </div>
        </PushButton>
      </span>
    </div>
  </div>
</template>
