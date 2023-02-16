<script setup lang="ts">
import type { PropType } from '@vue/runtime-core'

const props = defineProps({
  entry: {
    type: Object as PropType<components.SmartTableRow>,
    required: false,
    default: undefined,
  },
  identifier: {
    type: [String, Number] as PropType<string | number>,
    required: true,
  },
  srOnly: {
    type: String as PropType<string>,
    required: false,
    default: 'Checkbox For Table',
  },
})

const emit = defineEmits<{
  (e: 'change', entry: components.SmartTableRow | undefined, event: Event): void
}>()

const propIdentifier = String(props.identifier)
</script>

<template>
  <label :for="propIdentifier">
    <span class="sr-only">{{ srOnly }}</span>
    <input
      :id="propIdentifier"
      type="checkbox"
      class="focus:ring-blue-500 focus:shadow-inner h-4 w-4 text-blue-300 rounded border-2 hover:bg-blue-500 hover:border-blue-300 cursor-pointer"
      @change="emit('change', props.entry, $event)"
    />
  </label>
</template>
