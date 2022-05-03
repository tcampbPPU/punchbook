
<template>
  <div>
    <nav class="flex justify-between px-4 sm:px-6 border-b border-gray-300 dark:border-gray-700 lg:border-0" aria-label="Breadcrumb">
      <ol class="flex items-center space-x-4 py-3">
        <transition-group
          mode="out-in"
          enter-active-class="transition ease-out duration-200 delay-200"
          enter-from-class="transform -translate-x-2 opacity-0"
          enter-to-class="transform translate-x-0 opacity-100"
          leave-active-class="ease-in duration-200"
          leave-from-class="transform translate-x-0 opacity-100"
          leave-to-class="transform -translate-x-2 opacity-0"
        >
          <li key="home">
            <div>
              <router-link to="/" class="text-gray-400 hover:text-gray-500">
                <icon icon="fa-solid:home" class="w-5 h-5" />
                <span class="sr-only">Home</span>
              </router-link>
            </div>
          </li>

          <li v-for="crumb in props.crumbs" :key="crumb.label">
            <div v-if="crumb" class="flex items-center">
              <icon icon="mdi-chevron-right" class="w-5 h-5" />
              <router-link v-if="crumb && crumb.route" :to="crumb.route" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                <div class="flex items-center space-x-2">
                  <icon v-if="crumb.icon" :icon="crumb.icon" class="w-5 h-5" />
                  <span> {{ crumb.label }} </span>
                </div>
              </router-link>
              <span v-else class="ml-4 text-sm font-medium text-gray-500">
                <div class="flex items-center space-x-2">
                  <icon v-if="crumb.icon" :icon="crumb.icon" class="w-5 h-5" />
                  <span> {{ crumb.label }} </span>
                </div>
              </span>
            </div>
          </li>
        </transition-group>
      </ol>
    </nav>
    <div class="my-12 md:mx-12">
      <slot />
    </div>
  </div>
</template>
<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'
import { Icon } from '@iconify/vue'

const props = defineProps({
  crumbs: {
    type: Array as PropType<components.PageBreadCrumbs>,
    required: true,
  },
})

</script>
