<template>
  <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
    <tr
      v-for="index in props.rows"
      :key="index"
      :class="{
        'bg-gray-200 dark:bg-gray-800': index % 2 !== 0,
        'bg-white dark:bg-gray-700': index % 2 === 0,
      }"
    >
      <table-cell v-for="c in props.columns" :key="c">
        <span class="block w-12 rounded-sm sm:w-24 md:w-32 lg:w-60 skeleton">&nbsp;</span>
      </table-cell>
    </tr>
  </tbody>
</template>

<script lang="ts" setup>
import TableCell from '~/components/table/TableCell.vue'

const props = defineProps({
  rows: {
    type: Number,
    required: true,
  },
  columns: {
    type: Number,
    required: true,
  },
})

</script>
