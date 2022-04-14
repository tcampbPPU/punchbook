<template>
  <transition
    :mode="props.mode"
    enter-active-class="transition duration-200 ease-out"
    enter-class="transform translate-x-2 opacity-0"
    enter-to-class="transform translate-x-0 opacity-100"
    leave-active-class="duration-200 ease-in"
    leave-class="transform translate-x-0 opacity-100"
    leave-to-class="transform -translate-x-2 opacity-0"
  >
    <slot />
  </transition>
</template>
<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'
const props = defineProps({
  mode: {
    type: String as PropType<"default"|"out-in"|"in-out">,
    required: false,
    default: 'out-in',
  },
})
</script>
