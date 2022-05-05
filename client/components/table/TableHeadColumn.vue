<template>
  <div>
    <div v-if="props.column.field != 'checkbox'" class="flex items-center justify-start">
      <client-only>
        <transition-top-to-bottom>
          <div v-if="filtering" class="absolute bottom-0 -mb-11 left-4">
            <div class="relative z-50 border border-gray-300 rounded shadow dark:bg-gray-800">
              <div
                class="absolute top-0 w-3 h-3 transform rotate-45 border border-b-0 border-r-0 border-gray-300 dark:bg-gray-800 left-6"
                style="margin-top: -5px;"
              />
              <div class="flex items-center p-2">
                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                  <input
                    ref="target" v-model="input" type="text"
                    class="block w-full py-1 text-black border-gray-300 rounded-none dark:text-white dark:bg-gray-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-300 rounded-l-md sm:text-sm"
                    @keydown.enter="filter"
                  >
                </div>
                <button
                  class="relative inline-flex items-center px-4 py-2 -ml-px space-x-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-r-md bg-gray-50 dark:bg-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-1 focus:ring-blue-300 focus:border-blue-300"
                  @click="filter"
                >
                  <icon class="w-3 h-3 text-gray-300 hover:text-gray-500" icon="ci:filter" />
                </button>
              </div>
            </div>
          </div>
        </transition-top-to-bottom>
      </client-only>
      <div
        v-if="props.column.sortable"
        class="flex items-center space-x-2 text-gray-500 transition duration-150 ease-in-out cursor-pointer select-none hover:text-gray-600"
        @click="$emit('sort', props.column)"
      >
        <span> {{ props.column.label ? props.column.label : props.column.field }} </span>
        <icon class="w-4 h-4 text-gray-300 hover:text-gray-500" icon="bx:sort-alt-2" />
      </div>
      <div
        v-else
        class="flex items-center space-x-2 text-gray-500 transition duration-150 ease-in-out cursor-pointer select-none hover:text-gray-600"
      >
        <span> {{ props.column.label ? props.column.label : props.column.field }} </span>
      </div>
      <div v-if="props.column.filterable" class="ml-2 cursor-pointer" @click="toggle">
        <icon class="w-4 h-4 text-gray-300 hover:text-gray-500" icon="ci:filter" />
        <!-- <icon v-if="isFiltered" class="w-4 h-4 text-gray-300 hover:text-gray-500" icon="ci:filter" />
        <icon v-else class="w-4 h-4 text-gray-300 hover:text-gray-500" icon="ci:filter-off" /> -->
      </div>
    </div>
    <div v-else>
      <span v-if="props.column.field === 'checkbox'">
        <slot name="checkbox" />
      </span>
      <span v-else> {{ props.column.label ? props.column.label : props.column.field }} </span>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'
import { onClickOutside } from '@vueuse/core'
import { Icon } from '@iconify/vue'
import TransitionTopToBottom from '~/components/transition/TransitionTopToBottom.vue'
const emit = defineEmits(['filter', 'sort'])

const props = defineProps({
  column: {
    type: Object as PropType<components.SmartTableColumn>,
    required: true,
  },
  order: {
    type: String as PropType<string>,
    default: '',
  },
  direction: {
    type: String as PropType<string>,
    default: '',
  },
  isFiltered: {
    type: Boolean as PropType<boolean>,
    default: false,
  },
})

const target = ref(null)
const filtering = ref(false)
const input = ref('')
const { $utils } = useNuxtApp()

const off = async () => {
  await $utils.sleep(200)
  filtering.value = false
  input.value = null
}

const on = async () => {
  filtering.value = true
  await $utils.sleep(200)
}

const toggle = () => filtering.value ? off() : on()

const filter = () => {
  if (!input.value) return
  emit('filter', { column: props.column, input: input.value })
  off()
}

onClickOutside(target, () => off())

</script>
