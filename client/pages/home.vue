<template>
  <div class="mt-12">
    <h1 class="mb-4 text-center"> This page is behind auth middleware </h1>
    <span>$auth.user</span>
    <pre class="p-4 mb-4 text-xs text-gray-100 bg-gray-900 border rounded-lg"> {{ $auth.user }} </pre>
    <div class="flex justify-center">
      <router-link to="/">
        <push-button> Go to Index </push-button>
      </router-link>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { PushButton } from 'tailvue'
</script>
