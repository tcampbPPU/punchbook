<script setup lang="ts">
import { ModalBase, PushButton } from 'tailvue'
import { ref, watch } from 'vue'
import ContactCard from '~/components/contact/ContactCard.vue'
import ContactCardSkeleton from '~/components/contact/ContactCardSkeleton.vue'
import GlobalPaginate from '~/components/shared/GlobalPaginate.vue'
import { useSearch } from '~/composables/useSearch'

const { $api } = useNuxtApp()
const searchStr = useSearch()
const perPage = ref(12)
const currPage = ref(1)
const modal = ref(false)
const edit = ref(false)
const editContact = ref<models.Contact | undefined>(undefined)
const contacts = ref<api.HarmonyResults & { data: models.Contacts } | undefined>(undefined)

const on = () => (modal.value = true)
const off = () => {
  modal.value = false
  editContact.value = undefined
  edit.value = false
}

const get = async () =>
  (contacts.value = await $api.get('/contact', {
    perpage: perPage.value,
    page: currPage.value,
    search: searchStr.value,
  }))

const hydrate = ({ page }: { page: number }) => {
  const values = { ...contacts.value?.paginate?.pages }
  const pages = Object.values(values)
  currPage.value = page
  if (pages.includes(page))
    get()
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

get()

watch(
  () => searchStr.value,
  () => {
    get()
  },
)
</script>

<template>
  <div>
    <div class="container mx-auto flex flex-col p-2 lg:p-8">
      <div
        v-if="$api.loggedIn.value"
        class="flex flex-row-reverse justify-between pl-6 pr-6 text-center"
      >
        <PushButton
          theme="indigo"
          class="flex w-full justify-center border border-transparent px-4 py-2 lg:w-1/12"
          @click="on"
        >
          Create
        </PushButton>
      </div>
      <ul
        v-if="!contacts"
        class="grid w-full grid-cols-1 gap-6 rounded bg-gray-100 p-8 dark:bg-gray-900 sm:grid-cols-2 lg:grid-cols-3"
      >
        <ContactCardSkeleton v-for="i in 9" :key="`user-${i}`" />
      </ul>
      <ul
        v-else
        class="grid w-full grid-cols-1 gap-6 rounded bg-gray-100 p-8 dark:bg-gray-900 sm:grid-cols-2 lg:grid-cols-3"
      >
        <ContactCard
          v-for="contact in contacts.data"
          :key="contact.id"
          :contact="contact"
          @edit="onEdit"
        />
      </ul>
      <GlobalPaginate
        v-if="!contacts || (contacts.paginate && contacts.paginate.total > 0)"
        :paginate="contacts ? contacts.paginate : undefined"
        :hydrate="hydrate"
      />
    </div>
    <ModalBase v-if="modal" :destroyed="off">
      <contact-modal
        :edit="edit"
        :contact="editContact"
        @off="off"
        @change="onChanged"
      />
    </ModalBase>
  </div>
</template>
