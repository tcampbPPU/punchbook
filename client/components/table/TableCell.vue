<template>
  <td
    class="px-6 text-sm font-medium leading-5 whitespace-no-wrap"
    :class="{'py-4': !props.button, 'py-2': props.button, 'flash-new': props.isNew }"
    :colspan="span"
  >
    <slot />
  </td>
</template>
<script lang="ts" setup>
const props = defineProps({
  button: {
    type: Boolean,
    required: false,
    default: false,
  },
  span: {
    type: Number,
    required: false,
    default: 0,
  },
  isNew: {
    type: Boolean,
    required: false,
    default: false,
  },
})
</script>

<style scoped>
.flash-new {
  animation: flash-bg 2s ease-out;
}

@keyframes flash-bg {
  from {
    @apply bg-green-400;
  }
  to {
    @apply bg-auto;
  }
}
</style>
