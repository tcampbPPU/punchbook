<template>
  <div class="px-4 py-4 bg-white dark:bg-gray-800 sm:px-10">
    <label class="block text-sm font-medium leading-5 text-gray-700 dark:text-gray-500" for="name">Name</label>
    <div class="relative mt-1 rounded-md shadow-sm">
      <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <icon icon="mdi:user" class="w-5 h-5 text-gray-400" />
      </div>
      <input
        id="name"
        ref="input"
        v-model="name"
        class="block w-full px-3 py-2 pl-10 placeholder-gray-400 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none form-input dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
        :readonly="loading.attempt"
        placeholder="John Doe"
        type="text"
        @keydown.esc="off"
      >
    </div>
    <label class="block mt-6 text-sm font-medium leading-5 text-gray-700 dark:text-gray-500" for="phone">Phone</label>
    <div class="relative mt-1 rounded-md shadow-sm">
      <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <icon icon="mdi:phone" class="w-5 h-5 text-gray-400" />
      </div>
      <input
        id="phone"
        ref="input"
        v-model="phone"
        class="block w-full px-3 py-2 pl-10 placeholder-gray-400 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none form-input dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
        :readonly="loading.attempt"
        placeholder="123-456-7890"
        type="phone"
        @keydown.esc="off"
      >
    </div>
    <label class="block mt-6 text-sm font-medium leading-5 text-gray-700 dark:text-gray-500" for="email">Email address</label>
    <div class="relative mt-1 rounded-md shadow-sm">
      <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <icon icon="mdi:envelope" class="w-5 h-5 text-gray-400" />
      </div>
      <input
        id="email"
        ref="input"
        v-model="email"
        class="block w-full px-3 py-2 pl-10 placeholder-gray-400 transition duration-150 ease-in-out border border-gray-300 rounded-md appearance-none form-input dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5"
        :readonly="loading.attempt"
        placeholder="email@address.com"
        type="email"
        @keydown.esc="off"
      >
    </div>
    <div class="mt-6">
      <span class="block w-full rounded-md shadow-sm">
        <push-button
          v-if="edit"
          theme="indigo"
          class="justify-center w-full"
          @click="update"
        >
          Update
          <div v-if="loading.attempt" class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <icon icon="gg:spinner-two" class="w-5 h-5 text-indigo-200 animate-spin" />
          </div>
        </push-button>
        <push-button
          v-else
          theme="indigo"
          class="justify-center w-full"
          @click="save"
        >
          Create
          <div v-if="loading.attempt" class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <icon icon="gg:spinner-two" class="w-5 h-5 text-indigo-200 animate-spin" />
          </div>
        </push-button>
      </span>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'
import { PushButton } from 'tailvue'
import { Icon } from '@iconify/vue'

const emit = defineEmits(['off', 'change'])
const props = defineProps({
  edit: {
    type: Boolean,
    required: false,
    default: false,
  },
  contact: {
    type: Object as PropType<models.Contact>,
    required: false,
    default: undefined,
  },
})
const { $api } = useNuxtApp()
const name = ref('')
const phone = ref('')
const email = ref('')
const loading = reactive({
  attempt: false,
} as Record<string, boolean>)

onMounted(() => {
  if (props.edit) {
    name.value = props.contact.name
    phone.value = props.contact.phone
    email.value = props.contact.email
  }
})

async function save (): Promise<void> {
  loading.attempt = true
  const result = await $api.store('/contact', {
    name: name.value,
    phone: phone.value,
    email: email.value,
  })
  loading.attempt = false
  if (result) emit('change')
}

async function update (): Promise<void> {
  loading.attempt = true
  const result = await $api.put(`/contact/${props.contact.id}`, {
    name: name.value,
    phone: phone.value,
    email: email.value,
  })
  loading.attempt = false
  if (result) emit('change')
}

const off = () => emit('off')

</script>
