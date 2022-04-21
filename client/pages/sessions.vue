<template>
  <page-container>
    <template #crumbs>
      <bread-crumbs :crumbs="crumbs" />
    </template>
    <template #main>
      <div class="max-w-5xl py-6 mx-auto sm:px-6 lg:px-8">
        <session-list :sessions="sessions" @refresh="get" />
      </div>
    </template>
  </page-container>
</template>

<script lang="ts" setup>
import { ref } from '@vue/reactivity'
import { useAuthMiddleware } from '~/composables/useAuthMiddleware'
import SessionList from '~/components/session/SessionList.vue'
import PageContainer from '~/components/page/PageContainer.vue'
import BreadCrumbs from '~/components/page/BreadCrumbs.vue'

// Route Guard
useAuthMiddleware()

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
const get = async () => sessions.value = (await $api.index('/session')).data
get()

</script>
