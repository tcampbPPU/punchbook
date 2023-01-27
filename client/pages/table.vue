<script lang="ts" setup>
import { computed } from 'vue'
import ContactList from '~/components/contact/ContactList.vue'
import PageContainer from '~/components/page/PageContainer.vue'

const crumbs = computed((): components.PageBreadCrumbs => {
  return [
    {
      label: 'Smart Table Example',
      route: '/table',
    },
  ]
})
</script>

<template>
  <PageContainer :crumbs="crumbs">
    <div class="container mx-auto flex flex-col p-2 lg:p-8">
      <ContactList />
    </div>
  </PageContainer>
</template>
