<script lang="ts" setup>
import type { PropType } from '@vue/runtime-core'
import { onMounted } from '@vue/runtime-core'
import { ref } from 'vue'
import TableBase from '~/components/table/TableBase.vue'
import TableSkeleton from '~/components/table/TableSkeleton.vue'

const props = defineProps({
  params: {
    type: Object as PropType<components.SmartTableParams>,
    required: true,
  },
})

const { $api } = useNuxtApp()
const results = ref<api.HarmonyResults | undefined>(undefined)
const order = ref(props.params.defaults.order)
const direction = ref(props.params.defaults.direction)
const filters = ref<components.SmartTableFilters>([])
const selectedRows = ref<number[]>([])

const get = async (args: components.SmartTableFetchParams): Promise<void> => {
  const defaults: components.SmartTableFetchParams = {
    page: 1,
    order: order.value,
    direction: direction.value,
    filterFields: filters.value.map(f => f.column.field),
    filterInputs: filters.value.map(f => f.input),
  }

  const payload = {
    ...defaults,
    ...args,
  }

  results.value = (await $api.index(
    props.params.route,
    payload,
  )) as api.HarmonyResults
}

const sort = (column: components.SmartTableColumn) => {
  if (column.field === order.value) {
    direction.value = direction.value === 'desc' ? 'asc' : 'desc'
  }
  else {
    order.value = column.field
    direction.value = props.params.defaults.direction
  }
  get({ page: 1 })
}

const removeFilter = (
  filter: components.SmartTableFilter,
  refreshes = false,
) => {
  const index = filters.value.findIndex(
    f => f.column.field === filter.column.field,
  )
  if (index !== -1)
    filters.value.splice(index, 1)
  if (refreshes)
    get({ page: 1 })
}

const filter = (filter: components.SmartTableFilter) => {
  removeFilter(filter)
  filters.value.push(filter)
  get({ page: 1 })
}

onMounted(() => get({ page: 1 }))

defineExpose({
  get,
})
</script>

<template>
  <div class="relative rounded-lg">
    {{ selectedRows }}
    <TableBase class="relative">
      <!-- Table Loading Skeleton Screen -->
      <TableSkeleton v-if="!results" :columns="3" :rows="10" />
      <table-head-smart
        :columns="params.columns"
        :order="params.defaults.order"
        :direction="params.defaults.direction"
        :checkable="params.checkable"
        :actions="params.actions"
        :filters="filters"
        :selected-ids="selectedRows"
        @sort="sort"
        @filter="filter"
      />
      <tbody
        v-if="results && results.paginate && results.paginate.total > 0"
        class="divide-y divide-gray-200"
      >
        <template v-for="(entry, index) in results.data" :key="index">
          <table-row-smart
            :index="index"
            :entry="entry"
            :columns="params.columns"
            :actions="params.actions"
            :checkable="params.checkable"
          >
            <template
              v-for="(_, scopedSlotName) in $slots"
              #[scopedSlotName]="slotData"
            >
              <slot :name="scopedSlotName" v-bind="slotData"></slot>
            </template>
          </table-row-smart>
        </template>
      </tbody>
    </TableBase>
  </div>
</template>
