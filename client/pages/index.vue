<template>
  <div>
    <div class="container flex flex-col p-2 mx-auto lg:p-8">
      <div v-if="$api.loggedIn.value" class="flex flex-row-reverse justify-between pl-6 pr-6 text-center">
        <push-button
          theme="indigo"
          class="flex justify-center w-full px-4 py-2 border border-transparent lg:w-1/12"
          @click="on"
        >
          Create
        </push-button>
      </div>
      <ul v-if="!contacts" class="grid w-full grid-cols-1 gap-6 p-8 bg-gray-100 rounded dark:bg-gray-900 sm:grid-cols-2 lg:grid-cols-3">
        <contact-card-skeleton v-for="i in 9" :key="`user-${i}`" />
      </ul>
      <ul v-else class="grid w-full grid-cols-1 gap-6 p-8 bg-gray-100 rounded dark:bg-gray-900 sm:grid-cols-2 lg:grid-cols-3">
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
const contacts = ref<api.HarmonyResults & { data: models.Contacts[] }>(undefined)

watch(() => searchStr.value, () => {
  get()
})

const hydrate = ({page}: {page: number}) => {
  const values = { ...contacts.value.paginate.pages}
  const pages = Object.values(values)
  currPage.value = page
  if (pages.includes(page)) get()
}

const onChanged = async () => {
  await get()
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

const get = async () => contacts.value = (await $api.index('/contact', { perpage: perPage.value, page: currPage.value, search: searchStr.value }))

get()

</script>
