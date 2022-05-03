<template>
  <div class="flex justify-center flex-1 px-2 lg:ml-6 lg:justify-end">
    <div class="w-full max-w-lg lg:max-w-xs">
      <label for="search" class="sr-only">Search</label>
      <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <icon icon="mdi:search" class="w-5 h-5 text-gray-400" />
        </div>
        <input
          id="search"
          ref="searchInput"
          name="search"
          class="block w-full py-2 pl-10 pr-3 leading-5 text-gray-300 placeholder-gray-300 placeholder-opacity-0 bg-opacity-50 border border-transparent rounded-md shadow-inner md:placeholder-opacity-100 bg-brand-navy-200 dark:bg-gray-600 dark:text-white focus:placeholder-gray-400 focus:outline-none focus:bg-white focus:border-white focus:ring-white focus:text-gray-900 dark:focus:bg-gray-600 dark:focus:ring-gray-600 dark:focus:text-gray-100 sm:text-sm"
          placeholder="Search Contact"
          type="search"
          @input="onInputChange"
          @focus="focused = true"
          @blur="focused = false"
        >
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { Icon } from '@iconify/vue'
import { useSearch } from '~/composables/useSearch'
const { $utils } = useNuxtApp()
const searchStr = useSearch()
const focused = ref(false)
const onInputChange = $utils.debounce((e: { target: { value: string } }): void => {
  searchStr.value = e.target.value
}, 300)
</script>
