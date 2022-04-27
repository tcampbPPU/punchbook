<template>
  <thead class="relative">
    <tr>
      <th
        v-for="column in props.columns"
        :key="column.field"
        class="relative px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50 dark:bg-gray-700 dark:text-white"
      >
        <table-head-column
          :column="column"
          :order="order"
          :direction="direction"
          :is-filtered="isFiltered()"
          @sort="$emit('sort', $event)"
          @filter="$emit('filter', $event)"
        />
      </th>

      <!-- maybe good place for actions -->
      <th
        class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50 dark:bg-gray-700"
        v-html="'Actions'"
      />
    </tr>
  </thead>
</template>

<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'

defineEmits(['filter', 'sort'])

const props = defineProps({
  columns: {
    type: Array as PropType<components.SmartTableColumn[]>,
    required: true,
  },
  order: {
    type: String as PropType<string>,
    required: true,
  },
  direction: {
    type: String as PropType<string>,
    required: true,
  },
  checkable: {
    type: Object as PropType<components.Checkable>,
    required: false,
  },
})

const isFiltered = () => true

</script>