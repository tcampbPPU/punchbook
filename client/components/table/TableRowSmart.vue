<script lang="ts" setup>
import type { PropType } from '@vue/runtime-core'
import BasicCheckbox from '~/components/shared/BasicCheckbox.vue'

const props = defineProps({
  index: {
    type: Number as PropType<number>,
    required: true,
  },
  entry: {
    type: Object as PropType<components.SmartTableRow>,
    required: true,
  },
  columns: {
    type: Array as PropType<components.SmartTableColumn[]>,
    required: true,
  },
  actions: {
    type: Boolean as PropType<boolean>,
    required: false,
    default: false,
  },
  checkable: {
    type: Object as PropType<components.Checkable>,
    required: false,
    default: undefined,
  },
  selectedIds: {
    type: Array as PropType<number[]>,
    required: false,
    default: undefined,
  },
})

const emit = defineEmits<{
  (event: 'checkboxChanged', ...args: any[]): void
}>()

const { $dayjs } = useNuxtApp()

const mapColumnEntry = (entry: components.SmartTableRow, key: string): string =>
  entry[key]

const onCheckBoxChange = (entry: components.SmartTableRow | undefined, event: Event): void => {
  if (!entry)
    return
  const target = event.target as HTMLInputElement
  emit('checkboxChanged', entry, target.checked)
}
</script>

<template>
  <table-row :key="props.index" :index="props.index">
    <table-cell
      v-for="(column, i) in columns"
      :key="i"
      class="dark:text-white dark:bg-gray-800"
    >
      <!-- Checkable -->
      <span v-if="checkable && column.type === 'checkbox'">
        <div class="relative flex items-start">
          <div class="flex items-center h-5">
            <slot v-if="checkable.slot" name="checkbox" :entry="entry"></slot>
            <BasicCheckbox v-else :entry="entry" :identifier="`checkbox-${entry.id}`" @change="onCheckBoxChange" />
          </div>
        </div>
      </span>
      <!-- Text -->
      <span
        v-if="column.type === 'text'"
        v-html="mapColumnEntry(props.entry, column.field)"
      ></span>

      <!-- Date -->
      <span
        v-else-if="column.type === 'date'"
        v-html="$dayjs(mapColumnEntry(props.entry, column.field)).fromNow()"
      ></span>

      <!-- Links/URL -->
      <span v-else-if="column.type === 'link'">
        <router-link
          :to="mapColumnEntry(props.entry, column.field)"
          class="text-gray-400 dark:text-white hover:text-gray-500"
        >
          <span v-html="mapColumnEntry(props.entry, column.field)"></span>
        </router-link>
      </span>

      <!-- Dynamic Slot -->
      <slot
        v-else-if="column.type === 'slot'"
        :name="column.field"
        :entry="props.entry"
      ></slot>
    </table-cell>
    <!-- maybe good place for actions -->
    <table-cell v-if="props.actions" class="dark:text-white dark:bg-gray-800">
      <slot name="actions" data="Actions"></slot>
    </table-cell>
  </table-row>
</template>
