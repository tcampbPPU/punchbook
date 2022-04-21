<template>
  <page-container>
    <template #crumbs>
      <bread-crumbs :crumbs="crumbs" />
    </template>
    <template #main>
      <div class="container flex flex-col p-2 mx-auto lg:p-8">
        <contact-list />
      </div>
    </template>
  </page-container>
</template>
<script lang="ts" setup>
import PageContainer from '~/components/page/PageContainer.vue'
import BreadCrumbs from '~/components/page/BreadCrumbs.vue'
import ContactList from '~/components/contact/ContactList.vue'

const crumbs = computed((): components.PageBreadCrumbs => {
  return [
    {
      label: 'Smart Table Example',
      route: '/table',
    },
  ]
})
</script>
