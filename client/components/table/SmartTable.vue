<template>
  <div
    class="relative rounded-lg"
  >
    <table-base class="relative">
      <!-- Table Loading Skeleton Screen -->
      <table-skeleton
        v-if="!results"
        :columns="3"
        :rows="10"
      />
      <!-- {{ results }} -->
      <table-head-smart
        :columns="props.params.columns"
        :order="props.params.defaults.order"
        :direction="props.params.defaults.direction"
        :checkable="props.params.checkable"
      />
      <tbody
        v-if="results && results.paginate && results.paginate.total > 0"
        class="divide-y divide-gray-200"
      >
        <template v-for="(entry, index) in results.data" :key="index">
          <table-row-smart
            :index="index"
            :entry="entry"
            :columns="props.params.columns"
          >
            <template
              v-for="(_, scopedSlotName) in $slots"
              #[scopedSlotName]="slotData"
            >
              <slot
                :name="scopedSlotName"
                v-bind="slotData"
              />
            </template>
          </table-row-smart>
        </template>
      </tbody>
    </table-base>
  </div>
</template>
<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'
import TableBase from '~/components/table/TableBase.vue'
import TableSkeleton from '~/components/table/TableSkeleton.vue'

const props = defineProps({
  params: {
    type: Object as PropType<components.SmartTableParams>,
    required: true,
  },
})

const { $api } = useNuxtApp()
const results = ref<api.HarmonyResults>(undefined)

const get = async (args: components.SmartTableFetchParams): Promise<void> => {
  const payload = {
    ...args,
  }
  results.value = (await $api.index(props.params.route, payload)) as api.HarmonyResults
}

onMounted(() => get({ page: 1 }))

</script>
