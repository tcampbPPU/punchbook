import Utils from '~/lib/utils'

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.provide('utils', new Utils())
})

declare module '#app' {
  interface NuxtApp {
    $utils: typeof Utils
 }
}
