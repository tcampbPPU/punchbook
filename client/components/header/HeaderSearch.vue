<template>
  <div class="flex-1 flex justify-center px-2 lg:ml-6 lg:justify-end">
    <div class="max-w-lg w-full lg:max-w-xs">
      <label for="search" class="sr-only">Search</label>
      <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <icon-client icon="mdi:search" class="w-5 h-5 text-gray-400" />
        </div>
        <input
          id="search"
          ref="searchInput"
          v-model="searchStr"
          name="search"
          class="block w-full pl-10 pr-3 py-2 border border-transparent rounded-md leading-5 bg-brand-navy-200 bg-opacity-50 shadow-inner dark:bg-gray-600 text-gray-300 dark:text-white placeholder-gray-300 focus:placeholder-gray-400 focus:outline-none focus:bg-white focus:border-white focus:ring-white focus:text-gray-900 dark:focus:bg-gray-600 dark:focus:bg-gray-600 dark:focus:ring-gray-600 dark:focus:text-gray-100 sm:text-sm"
          placeholder="Search Contact"
          type="search"
          @focus="focused = true"
          @blur="focused = false"
        >
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { useSearch } from '~~/client/composables/useSearch';
const searchStr = useSearch()
</script>
