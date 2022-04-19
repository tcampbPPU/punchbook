<template>
  <div class="relative mt-6">
    <div class="absolute inset-0 flex items-center">
      <div class="w-full border-t border-gray-300" />
    </div>
    <div class="relative flex justify-center text-sm leading-5">
      <span class="px-2 text-gray-500 bg-gray-100 dark:bg-gray-900">
        <slot />
      </span>
    </div>
  </div>
</template>
