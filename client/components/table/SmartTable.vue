<template>
  <div
    class="relative rounded-lg"
  >
    <table-base class="relative">
      <!-- Table Loading Skeleton Screen -->
      <table-skeleton
        :columns="3"
        :rows="10"
      />
    </table-base>
  </div>
</template>
<script lang="ts" setup>
import TableBase from '~/components/table/TableBase.vue'
import TableSkeleton from '~/components/table/TableSkeleton.vue'
</script>
