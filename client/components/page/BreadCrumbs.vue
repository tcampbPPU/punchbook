<template>
  <header class="bg-white border-t border-gray-100 shadow-sm dark:bg-gray-900 dark:border-gray-700">
    <nav class="flex bg-white border-b border-gray-200 dark:border-gray-900 dark:bg-gray-800" aria-label="Breadcrumb">
      <ol
        class="flex w-full pl-4 pr-2 ml-3 mr-2 space-x-4 sm:mr-4 lg:mr-12 lg:ml-14 3xl:mx-auto max-w-8xl sm:pl-6 lg:px-8 3xl:pl-10"
      >
        <li class="flex">
          <div class="flex items-center">
            <router-link to="/" class="text-gray-400 dark:text-white hover:text-gray-500">
              <icon-client icon="mdi:home" class="w-5 h-5" />
              <span class="sr-only">Home</span>
            </router-link>
          </div>
        </li>
        <li class="flex">
          <div v-for="(crumb, index) in props.crumbs" :key="index" class="flex items-center">
            <svg
              class="flex-shrink-0 w-6 h-full text-gray-200 dark:text-gray-700" viewBox="0 0 24 44"
              preserveAspectRatio="none" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
              aria-hidden="true"
            >
              <path d="M.293 0l22 22-22 22h1.414l22-22-22-22H.293z" />
            </svg>
            <div
              v-if="crumb.label === undefined"
              class="w-24 ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-white skeleton"
            >
              &nbsp;
            </div>
            <router-link
              v-else-if="crumb.route" :to="crumb.route"
              class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-white"
            >
              {{ crumb.label }}
            </router-link>
            <div v-else class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-white">
              {{ crumb.label }}
            </div>
          </div>
        </li>
        <li key="slot" class="flex items-center justify-end flex-1">
          <slot />
        </li>
      </ol>
    </nav>
  </header>
</template>
<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'
import IconClient from '~/components/IconClient.vue'

const props = defineProps({
  crumbs: {
    type: Array as PropType<components.PageBreadCrumbs>,
    required: true,
  },
})

</script>
