<script lang="ts" setup>
defineProps({
  appear: Boolean,
})
</script>

<template>
  <transition
    :appear="appear"
    mode="out-in"
    enter-active-class="transition ease-out duration-100"
    enter-from-class="transform scale-95 opacity-0"
    enter-to-class="transform scale-100 opacity-100"
    leave-active-class="ease-in duration-75"
    leave-from-class="transform scale-100 opacity-100"
    leave-to-class="transform scale-95 opacity-0"
  >
    <slot></slot>
  </transition>
</template>
