<template>
  <transition
    :appear="props.appear"
    mode="out-in"
    enter-active-class="transition duration-200 ease-out"
    enter-class="transform opacity-0"
    enter-to-class="transform opacity-100"
    leave-active-class="duration-200 ease-in"
    leave-class="transform opacity-100"
    leave-to-class="transform opacity-0"
  >
    <slot />
  </transition>
</template>
<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'
const props = defineProps({
  appear: {
    type: Boolean as PropType<boolean>,
    required: true,
  },
})
</script>
