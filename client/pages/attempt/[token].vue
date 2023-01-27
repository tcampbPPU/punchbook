<script lang="ts" setup>
import { useRoute, useRouter } from 'vue-router'
import { Icon } from '@iconify/vue'

const { $api, $utils } = useNuxtApp()
const route = useRoute()
const router = useRouter()
const verify = async () => {
  const redirect = await $api.login(await $api.attempt(route.params.token))
  await $utils.sleep(400)
  await router.push(redirect)
}
useHead({ title: 'Authenticating..' })
if (getCurrentInstance())
  onMounted(verify)
</script>

<script lang="ts">
export default { layout: 'public' }
</script>

<template>
  <div class="flex h-screen w-screen items-center justify-center">
    <Icon icon="eos-icons:loading" class="h-12 w-12" />
  </div>
</template>
