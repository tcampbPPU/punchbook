<template>
  <table-row :key="props.index" :index="props.index">
    <table-cell v-for="(column, i) in columns" :key="i" class="dark:text-white dark:bg-gray-800">
      <!-- Text -->
      <span v-if="column.type === 'text'" v-html="mapColumnEntry(props.entry, column.field)" />

      <!-- Date -->
      <span v-else-if="column.type === 'date'" v-html="$dayjs(mapColumnEntry(props.entry, column.field)).fromNow()" />

      <!-- Links/URL -->
      <span v-else-if="column.type === 'link'">
        <router-link
          :to="mapColumnEntry(props.entry, column.field)"
          class="text-gray-400 dark:text-white hover:text-gray-500"
        >
          <span v-html="mapColumnEntry(props.entry, column.field)" />
        </router-link>
      </span>

      <!-- Dynamic Slot -->
      <slot v-else-if="column.type === 'slot'" :name="column.field" :entry="props.entry" />
    </table-cell>
    <!-- maybe good place for actions -->
    <table-cell v-if="props.actions" class="dark:text-white dark:bg-gray-800">
      <slot :name="'actions'" :data="'Actions'" />
    </table-cell>
  </table-row>
</template>

<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'

const props = defineProps({
  index: {
    type: Number as PropType<number>,
    required: true,
  },
  entry: {
    type: Object as PropType<Record<string, string>>,
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
})

const { $dayjs } = useNuxtApp()

const mapColumnEntry = (entry: Record<string, string>, key: string): string => entry[key]

</script>
