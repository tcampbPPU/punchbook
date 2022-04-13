<template>
  <div>
    <li class="col-span-1 bg-white dark:bg-gray-700 rounded-lg shadow">
      <div v-if="$api.loggedIn.value" class="flex flex-row-reverse text-center justify-between p-2">
        <push-button
          theme="gray"
          class="flex justify-center border border-transparent"
          @click="edit"
        >
          <icon-client icon="mdi:edit" class="w-5 h-5 text-gray-400" />
        </push-button>
      </div>
      <div class="w-full flex items-center justify-between p-6 space-x-6">
        <div class="flex-1 truncate">
          <div class="flex items-center space-x-3">
            <h3 class="text-gray-900 dark:text-gray-200 text-sm leading-5 font-lg truncate">
              {{ props.contact.name }}
            </h3>
          </div>
          <p class="mt-1 text-gray-500 dark:text-gray-400 text-sm leading-5 truncate flex space-x-2">
            <icon-client icon="mdi:envelope" class="w-5 h-5 text-gray-400" />
            <span>{{ props.contact.email }}</span>
          </p>
          <p class="mt-1 text-gray-500 dark:text-gray-400 text-sm leading-5 truncate flex space-x-2">
            <icon-client icon="mdi:phone" class="w-5 h-5 text-gray-400" />
            <span>{{ props.contact.phone }}</span>
          </p>
        </div>
        <img class="w-10 h-10 bg-gray-300 dark:border-gray-600 rounded-full flex-shrink-0" :src="props.contact.avatar" alt="avatar">
      </div>
      <div class="border-t border-gray-200 dark:border-gray-500">
        <div class="-mt-px flex">
          <div class="w-0 flex-1 flex border-r border-gray-200 dark:border-gray-500">
            <a
              class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm leading-5 text-gray-700 dark:text-gray-200 font-medium border border-transparent rounded-bl-lg transition ease-in-out duration-150 hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10"
              :href="`mailto: ${props.contact.email}`"
            >
              <icon-client icon="mdi:envelope" class="w-5 h-5 text-gray-400" />
              <span class="ml-3">Email</span>
            </a>
          </div>
          <div class="-ml-px w-0 flex-1 flex">
            <a
              class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm leading-5 text-gray-700 dark:text-gray-200 font-medium border border-transparent rounded-br-lg transition ease-in-out duration-150 hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10"
              :href="`tel:+${props.contact.phone}`"
            >
              <icon-client icon="mdi:phone" class="w-5 h-5 text-gray-400" />
              <span class="ml-3">Call</span>
            </a>
          </div>
        </div>
      </div>
    </li>
  </div>
</template>

<script lang="ts" setup>
import { useNuxtApp } from '#app'
import { PropType } from '@vue/runtime-core'
import IconClient from '~/components/IconClient.vue'

const emit = defineEmits(['edit'])
const props = defineProps({
  contact: {
    type: Object as PropType<models.Contact>,
    required: true,
  },
})
const { $api } = useNuxtApp()
const edit = () => emit('edit', {...props.contact})
</script>
