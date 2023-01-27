<script lang="ts" setup>
import HeaderApps from '~/components/header/HeaderApps.vue'
import HeaderDarkMode from '~/components/header/HeaderDarkMode.vue'
import HeaderProfile from '~/components/header/HeaderProfile.vue'
import HeaderSearch from '~/components/header/HeaderSearch.vue'
</script>

<template>
  <header class="bg-white dark:bg-gray-800">
    <nav class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8" aria-label="Top">
      <div
        class="flex items-center justify-between w-full py-3 border-b border-indigo-500 lg:border-none"
      >
        <div class="flex items-center">
          <div class="flex w-16 h-8">
            <router-link to="/" class="flex-shrink-0">
              <img src="/punchlist.svg" alt="PunchBook" class="h-8" />
            </router-link>
            <HeaderApps />
          </div>
        </div>
        <div class="flex items-center justify-center space-x-4">
          <HeaderSearch />
          <HeaderDarkMode />
          <HeaderProfile />
        </div>
      </div>
    </nav>
  </header>
</template>
