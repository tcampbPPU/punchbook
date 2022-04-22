<template>
  <page-container :crumbs="crumbs">
    <div class="container flex flex-col p-2 mx-auto lg:p-8">
      <contact-list />
    </div>
  </page-container>
</template>
<script lang="ts" setup>
import PageContainer from '~/components/page/PageContainer.vue'
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
