<template>
  <div class="flex flex-col items-center justify-center">
    <div class="py-12 text-center">
      this uses <i>useAuthMiddleware()</i> <b>pages/gated.vue</b>
    </div>
    <span class="p-2 text-xs"> $api.$user </span>
    <pre class="max-w-md p-4 overflow-hidden text-xs bg-gray-200 rounded-md dark:bg-gray-700"> {{ $api.$user }} </pre>
  </div>
</template>
<script lang="ts" setup>
useAuthMiddleware()
</script>
