<template>
  <smart-table
    ref="smartTable"
    :params="tableParams"
  >
  <!-- Slots -->
  </smart-table>
</template>
<script lang="ts" setup>
import SmartTable from '~/components/table/SmartTable.vue'

const tableParams = computed((): components.SmartTableParams => {
  return {
    route: '/contact',
    columns: [
      {
        label: 'Name',
        field: 'name',
        type: 'text',
        sortable: true,
        filterable: true,
      },
      {
        label: 'Phone',
        field: 'phone',
        type: 'text',
        sortable: true,
      },
      {
        label: 'Email',
        field: 'email',
        type: 'text',
        sortable: true,
      },
      {
        label: 'Updated At',
        field: 'updated_at',
        type: 'date',
        sortable: true,
      },
    ],
    defaults: {
      order: 'updated_at',
      direction: 'desc',
      columns: [
        'name',
        'phone',
        'email',
      ],
    },
    actions: true,
  }
})
</script>
