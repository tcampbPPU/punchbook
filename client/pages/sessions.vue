<script lang="ts" setup>
import { ref } from '@vue/reactivity'
import PageContainer from '~/components/page/PageContainer.vue'
import SessionList from '~/components/session/SessionList.vue'

// Route Guard
definePageMeta({
  middleware: 'auth',
})

const { $api } = useNuxtApp()

const crumbs = computed((): components.PageBreadCrumbs => {
  return [
    {
      label: 'Sessions',
      route: '/sessions',
    },
  ]
})

const sessions = ref<models.Sessions | undefined>(undefined)
const get = async () => (sessions.value = (await $api.get('/session')).data)
get()
</script>

<template>
  <PageContainer :crumbs="crumbs">
    <div class="mx-auto max-w-5xl py-6 sm:px-6 lg:px-8">
      <SessionList :sessions="sessions" @refresh="get" />
    </div>
  </PageContainer>
</template>
