<template>
  <div>
    <div class="mx-auto container p-2 lg:p-8 flex flex-col">
      <div v-if="$api.loggedIn.value" class="flex flex-row-reverse text-center justify-between pl-6 pr-6">
        <push-button
          theme="indigo"
          class="w-full lg:w-1/12 flex justify-center py-2 px-4 border border-transparent"
          @click="on"
        >
          Create
        </push-button>
      </div>
      <ul v-if="!contacts" class="grid grid-cols-1 gap-6 bg-gray-100 dark:bg-gray-900 rounded p-8 w-full sm:grid-cols-2 lg:grid-cols-3">
        <contact-card-skeleton v-for="i in 9" :key="`user-${i}`" />
      </ul>
      <ul v-else class="grid grid-cols-1 gap-6 bg-gray-100 dark:bg-gray-900 rounded p-8 w-full sm:grid-cols-2 lg:grid-cols-3">
        <contact-card
          v-for="(contact, index) in contacts.data"
          :key="index"
          :contact="contact"
          @edit="onEdit"
        />
      </ul>
      <global-paginate
        v-if="!contacts || (contacts.paginate && contacts.paginate.total > 0)"
        :paginate="contacts ? contacts.paginate : undefined"
        :hydrate="hydrate"
      />
    </div>
    <modal-base v-if="modal" :destroyed="off">
      <contact-modal
        :edit="edit"
        :contact="editContact"
        @off="off"
        @change="onChanged"
      />
    </modal-base>
  </div>
</template>
<script setup lang="ts">
import { useAsyncData, useNuxtApp } from '#app'
import { Ref } from '@vue/reactivity'
import { PushButton, ModalBase } from 'tailvue'
import ContactCardSkeleton from '~/components/contact/ContactCardSkeleton.vue'
import ContactCard from '~/components/contact/ContactCard.vue'
import GlobalPaginate from '~/components/shared/GlobalPaginate.vue'
import { useSearch } from '~/composables/useSearch'

const searchStr = useSearch()
const { $api } = useNuxtApp()
const perPage = ref(12)
const currPage = ref(1)
const modal = ref(false)
const edit = ref(false)
const editContact = ref<models.Contact|undefined>(undefined)

const {
  data: contacts,
  refresh: refresh,
}: {
  data: Ref<api.MetApiResults & { data: models.Contacts[] }>
  refresh: (force?: boolean) => Promise<void>
} = useAsyncData(
  'contacts',
  () => $api.index<models.Contacts[]>('/contact', { perpage: perPage.value, page: currPage.value, search: searchStr.value }),
  { server: false },
)

watch(() => searchStr.value, () => {
  refresh()
})

const hydrate = ({page}: {page: number}) => {
  const values = { ...contacts.value.paginate.pages}
  const pages = Object.values(values)
  currPage.value = page
  if (pages.includes(page)) refresh()
}

const onChanged = async () => {
  await refresh()
  off()
}

const onEdit = (contact: models.Contact) => {
  editContact.value = contact
  edit.value = true
  on()
}

const on = () =>  modal.value = true
const off = () =>  {
  modal.value = false
  editContact.value = undefined
  edit.value = false
}
</script>
