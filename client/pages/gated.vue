<template>
  <div>
    <bread-crumbs :crumbs="crumbs" />
    <page-container>
      <div class="flex flex-col items-center justify-center">
        <div class="py-12 text-center">
          this uses <i>useAuthMiddleware()</i> <b>pages/gated.vue</b>
        </div>
        <span class="p-2 text-xs"> $api.$user </span>
        <client-only>
          <pre class="max-w-md p-4 overflow-hidden text-xs bg-gray-200 rounded-md dark:bg-gray-700">
          {{ $api.$user }}
        </pre>
        </client-only>
      </div>
    </page-container>
  </div>
</template>
<script lang="ts" setup>
import PageContainer from '~/components/page/PageContainer.vue'
import BreadCrumbs from '~/components/page/BreadCrumbs.vue'

// Route Guard
useAuthMiddleware()

const { $api } = useNuxtApp()

const crumbs = computed((): components.PageBreadCrumbs => {
  return [
    {
      label: 'Gate Example',
      route: '/gated',
    },
  ]
})
</script>
