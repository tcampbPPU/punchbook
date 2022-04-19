
<template>
  <header class="bg-white dark:bg-gray-800">
    <nav class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8" aria-label="Top">
      <div class="flex items-center justify-between w-full py-3 border-b border-indigo-500 lg:border-none">
        <div class="flex items-center">
          <div class="flex w-16 h-8">
            <router-link to="/" class="flex-shrink-0">
              <img src="/punchlist.svg" alt="PunchBook" class="h-8">
            </router-link>
            <header-apps />
          </div>
        </div>
        <div class="flex items-center justify-center space-x-4">
          <header-search />
          <header-dark-mode />
          <header-profile />
        </div>
      </div>
    </nav>
  </header>
</template>
<script lang="ts" setup>
import HeaderApps from '~/components/header/HeaderApps.vue'
import HeaderSearch from '~/components/header/HeaderSearch.vue'
import HeaderDarkMode from '~/components/header/HeaderDarkMode.vue'
import HeaderProfile from '~/components/header/HeaderProfile.vue'
</script>
