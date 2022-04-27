<template>
  <thead>
    <tr>
      <th
        v-for="column in props.columns" :key="column"
        class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50"
      >
        {{ column }}
      </th>
    </tr>
  </thead>
</template>
<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'

const props = defineProps({
  columns: {
    type: Array as PropType<string[]>,
    required: true,
  },
})

</script>
