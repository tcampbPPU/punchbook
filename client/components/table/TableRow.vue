<template>
  <tr
    :class="{ 'bg-white': props.index % 2 === 0 || !props.striped, 'bg-gray-50': props.index % 2 !== 0 && props.striped, 'hover:bg-blue-300 hover:text-white cursor-pointer group': props.selectable, 'hover:bg-gray-50': !props.selectable }"
    class="text-gray-500"
  >
    <slot />
  </tr>
</template>

<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'

const props = defineProps({
  index: {
    type: Number as PropType<number>,
    required: true,
  },
  striped: {
    type: Boolean as PropType<boolean>,
    required: false,
    default: false,
  },
  selectable: {
    type: Boolean as PropType<boolean>,
    required: false,
    default: false,
  },
})

</script>
