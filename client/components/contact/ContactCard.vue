<script lang="ts" setup>
import { PropType } from '@vue/runtime-core'
import { Icon } from '@iconify/vue'

const emit = defineEmits(['edit'])

const props = defineProps({
  contact: {
    type: Object as PropType<models.Contact>,
    required: true,
  },
})

const { $api } = useNuxtApp()

const edit = () => emit('edit', { ...props.contact })
</script>
<template>
  <div>
    <li class="col-span-1 rounded-lg bg-white shadow dark:bg-gray-700">
      <div
        v-if="$api.loggedIn.value"
        class="flex flex-row-reverse justify-between p-2 text-center"
      >
        <push-button
          theme="gray"
          class="flex justify-center border border-transparent"
          @click="edit"
        >
          <icon icon="mdi:edit" class="h-5 w-5 text-gray-400" />
        </push-button>
      </div>
      <div class="flex w-full items-center justify-between space-x-6 p-6">
        <div class="flex-1 truncate">
          <div class="flex items-center space-x-3">
            <h3
              class="font-lg truncate text-sm leading-5 text-gray-900 dark:text-gray-200"
            >
              {{ contact.name }}
            </h3>
          </div>
          <p
            class="mt-1 flex space-x-2 truncate text-sm leading-5 text-gray-500 dark:text-gray-400"
          >
            <icon icon="mdi:envelope" class="h-5 w-5 text-gray-400" />
            <span>{{ contact.email }}</span>
          </p>
          <p
            class="mt-1 flex space-x-2 truncate text-sm leading-5 text-gray-500 dark:text-gray-400"
          >
            <icon icon="mdi:phone" class="h-5 w-5 text-gray-400" />
            <span>{{ contact.phone }}</span>
          </p>
        </div>
        <img
          class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-300 dark:border-gray-600"
          :src="contact.avatar"
          alt="avatar"
        />
      </div>
      <div class="border-t border-gray-200 dark:border-gray-500">
        <div class="-mt-px flex">
          <div
            class="flex w-0 flex-1 border-r border-gray-200 dark:border-gray-500"
          >
            <a
              class="focus:shadow-outline-blue relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:text-gray-500 focus:z-10 focus:border-blue-300 focus:outline-none dark:text-gray-200"
              :href="`mailto: ${contact.email}`"
            >
              <icon icon="mdi:envelope" class="h-5 w-5 text-gray-400" />
              <span class="ml-3">Email</span>
            </a>
          </div>
          <div class="-ml-px flex w-0 flex-1">
            <a
              class="focus:shadow-outline-blue relative inline-flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:text-gray-500 focus:z-10 focus:border-blue-300 focus:outline-none dark:text-gray-200"
              :href="`tel:+${contact.phone}`"
            >
              <icon icon="mdi:phone" class="h-5 w-5 text-gray-400" />
              <span class="ml-3">Call</span>
            </a>
          </div>
        </div>
      </div>
    </li>
  </div>
</template>
