<template>
  <div class="h-6 ml-2">
    <client-only>
      <transition-group-left-to-right class="space-x-2">
        <span
          v-for="filter in props.filters"
          :key="filter.column.field"
          class="inline-flex rounded-full items-center py-0.5 text-xs font-medium"
        >
          <div class="flex items-center space-x-1">
            <span class="text-xs uppercase">{{ filter.column.label ? filter.column.label : filter.column.field }}:</span>
            <span class="font-semibold">{{ filter.input }}</span>
          </div>
          <button
            type="button"
            class="flex-shrink-0 h-4 w-4 ml-0.5 rounded-full inline-flex items-center justify-center focus:outline-none focus:text-white"
            @click="$emit('remove', filter)"
          >
            <span class="sr-only">Remove</span>
            <icon
              icon="mdi-close"
              class="w-2 h-2"
            />
          </button>
        </span>
      </transition-group-left-to-right>
    </client-only>
  </div>
</template>
<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'
import { Icon } from '@iconify/vue'

defineEmits(['remove'])

const props = defineProps({
  filters: {
    type: Array as PropType<components.SmartTableFilter[]>,
    required: true,
  },
})

</script>
