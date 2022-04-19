<template>
  <main class="px-2 py-6 mx-2 sm:mx-5 lg:mx-12 3xl:mx-auto max-w-8xl lg:px-8">
    <slot />
  </main>
</template>

<script lang="ts" setup>
const { $utils } = useNuxtApp()

// Smooth Scroll to anchor location in route
onMounted(async () => {
  await $utils.sleep(500)
  let { hash } = useRoute()
  if (!hash || hash === undefined) return
  hash = hash.replace('#', '')
  $utils.properScroll(hash)
})
</script>
