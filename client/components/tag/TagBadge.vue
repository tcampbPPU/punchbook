<template>
  <span
    class="inline-flex rounded-full items-center py-1 my-0.5 text-sm font-medium"
    v-bind="$attrs"
    :class="[
      {
        'text-white ': !textColor,
        'pl-2.5 pr-1': props.remove,
        'px-2.5': !props.remove
      }
    ]"
    :style="`background-color: ${props.color}`"
  >
    <span> {{ tag }} </span>
    <button
      v-if="props.remove"
      type="button"
      class="inline-flex items-center justify-center flex-shrink-0 w-4 h-4 mx-1 border rounded-full focus:outline-none focus:text-white"
      :class="disabled ? 'cursor-not-allowed' : null"
      :style="`background-color: ${color}`"
      :disabled="disabled"
      @click.stop="$emit('remove')"
    >
      <span class="sr-only">Remove</span>
      <icon
        icon="mdi-close"
        class="w-2 h-2"
      />
    </button>
  </span>
</template>
<script lang="ts" setup>
import { Icon } from '@iconify/vue'

defineEmits(['remove'])

const props = defineProps({
  text: {
    type: String,
    required: true,
  },
  color: {
    type: String,
    required: false,
    default: '#1b05e6',
  },
  disabled: {
    type: Boolean,
    required: false,
    default: false,
  },
  remove: {
    type: Boolean,
    required: false,
    default: false,
  },
})

const { $utils } = useNuxtApp()

const tag = computed(() => $utils.shortStr(props.text, 25))

const textColor = $utils.textContrast(props.color)

</script>
