<template>
  <page-container :crumbs="crumbs">
    <div class="max-w-5xl py-6 mx-auto sm:px-6 lg:px-8">
      <session-list :sessions="sessions" @refresh="get" />
    </div>
  </page-container>
</template>

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

const sessions = ref<models.Sessions>(undefined)
const get = async () => sessions.value = (await $api.get('/session')).data
get()

</script>
