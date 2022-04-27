<template>
  <div>
    <bread-crumbs v-if="props.crumbs.length" :crumbs="crumbs" />
    <main class="px-2 py-6 mx-2 sm:mx-5 lg:mx-12 3xl:mx-auto max-w-8xl lg:px-8">
      <slot />
    </main>
  </div>
</template>

<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'
import BreadCrumbs from '~/components/page/BreadCrumbs.vue'

const { $utils } = useNuxtApp()

const props = defineProps({
  crumbs: {
    type: Array as PropType<components.PageBreadCrumbs>,
    required: false,
    default: () => [],
  },
})

// Smooth Scroll to anchor location in route
onMounted(async () => {
  await $utils.sleep(500)
  let { hash } = useRoute()
  if (!hash || hash === undefined) return
  hash = hash.replace('#', '')
  $utils.properScroll(hash)
})
</script>
