<template>
  <client-only>
    <div
      v-if="!props.paginate"
      class="flex items-center justify-around lg:justify-between"
    >
      <p class="w-24 skeleton"> &nbsp; </p>
      <div class="inline-flex rounded shadow-sm">
        <push-button><span class="w-4 skeleton"> &nbsp; </span></push-button>
        <push-button><span class="w-4 skeleton"> &nbsp; </span></push-button>
        <push-button><span class="w-4 skeleton"> &nbsp; </span></push-button>
      </div>
    </div>
    <div
      v-else
      class="flex items-center justify-around lg:justify-between"
    >
      <p class="hidden py-2 pl-1 text-sm leading-5 text-gray-700 lg:block">
        Showing
        <span class="font-medium">
          {{ props.paginate.first_item }}
        </span>
        to
        <span class="font-medium">
          {{ props.paginate.last_item }}
        </span>
        of
        <span class="font-medium">
          {{ props.paginate.total }}
        </span>
        results
      </p>

      <div v-if="props.paginate.last_page !== 1" class="inline-flex shadow-sm">
        <push-button
          group="left"
          :state="props.paginate.current_page === 1 ? 'disabled' : 'active'"
          @click="hydrate({page: props.paginate.current_page - 1})"
        >
          <span class="sr-only">Paginate Table Left</span>
          <span v-html="previous" />
        </push-button>
        <push-button
          v-for="(page, index) in pages"
          :key="index"
          class="hidden md:inline"
          :state="!Number.isInteger(page) ? 'disabled' : 'active'"
          group="middle"
          @click="hydrate({page})"
        >
          <span :class="{'text-brand-light-blue-400': page === props.paginate.current_page}">
            {{ page }}
          </span>
        </push-button>
        <push-button
          group="right"
          :state="props.paginate.current_page === props.paginate.last_page ? 'disabled' : 'active'"
          @click="hydrate({page: props.paginate.current_page + 1})"
        >
          <span class="sr-only">Paginate Table Right</span>
          <span v-html="next" />
        </push-button>
      </div>
    </div>
  </client-only>
</template>
<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'
import { PushButton } from 'tailvue'
const props = defineProps({
    paginate: Object as PropType<api.HarmonyPaginate|undefined>,
    hydrate: {
      type: Function,
      required: true,
    },
})

const previous = computed((): string => {
  if (props.paginate && props.paginate.pages) return props.paginate.pages[0].toString()
})

const next = computed((): string => {
  if (props.paginate && props.paginate.pages) return props.paginate.pages[props.paginate.pages.length - 1].toString()
})

const pages = computed((): string|number[] => {
  if (props.paginate && props.paginate.pages) return props.paginate.pages.slice(1, -1)
})

</script>
