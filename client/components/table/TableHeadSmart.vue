<script lang="ts" setup>
import type { PropType } from '@vue/runtime-core'
import { getCurrentInstance } from '@vue/runtime-core'
import BasicCheckbox from '~/components/shared/BasicCheckbox.vue'

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
  actions: {
    type: Boolean as PropType<boolean>,
    required: false,
    default: false,
  },
  filters: {
    type: Array as PropType<components.SmartTableFilter[]>,
    required: false,
    default: () => [],
  },
})

defineEmits(['filter', 'sort'])

const component = getCurrentInstance()

const isFiltered = (column: components.SmartTableColumn): boolean => {
  return (
    props.filters.find(f => f.column.field === column.field) !== undefined
  )
}
</script>

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
          :is-filtered="isFiltered(column)"
          @sort="$emit('sort', $event)"
          @filter="$emit('filter', $event)"
        >
          <template #[column.type]>
            <span v-if="checkable && column.type === 'checkbox'">
              <div class="relative flex items-start">
                <div class="flex items-center h-5">
                  <BasicCheckbox :identifier="component?.uid ?? 'base'" />
                </div>
              </div>
            </span>
          </template>
        </table-head-column>
      </th>

      <!-- maybe good place for actions -->
      <th
        v-if="props.actions"
        class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase bg-gray-50 dark:bg-gray-700"
        v-html="'Actions'"
      ></th>
    </tr>
  </thead>
</template>
