<template>
  <div>
    <li class="col-span-1 bg-white rounded-lg shadow dark:bg-gray-700">
      <div v-if="$api.loggedIn.value" class="flex flex-row-reverse justify-between p-2 text-center">
        <push-button
          theme="gray"
          class="flex justify-center border border-transparent"
          @click="edit"
        >
          <icon icon="mdi:edit" class="w-5 h-5 text-gray-400" />
        </push-button>
      </div>
      <div class="flex items-center justify-between w-full p-6 space-x-6">
        <div class="flex-1 truncate">
          <div class="flex items-center space-x-3">
            <h3 class="text-sm leading-5 text-gray-900 truncate dark:text-gray-200 font-lg">
              {{ props.contact.name }}
            </h3>
          </div>
          <p class="flex mt-1 space-x-2 text-sm leading-5 text-gray-500 truncate dark:text-gray-400">
            <icon icon="mdi:envelope" class="w-5 h-5 text-gray-400" />
            <span>{{ props.contact.email }}</span>
          </p>
          <p class="flex mt-1 space-x-2 text-sm leading-5 text-gray-500 truncate dark:text-gray-400">
            <icon icon="mdi:phone" class="w-5 h-5 text-gray-400" />
            <span>{{ props.contact.phone }}</span>
          </p>
        </div>
        <img class="flex-shrink-0 w-10 h-10 bg-gray-300 rounded-full dark:border-gray-600" :src="props.contact.avatar" alt="avatar">
      </div>
      <div class="border-t border-gray-200 dark:border-gray-500">
        <div class="flex -mt-px">
          <div class="flex flex-1 w-0 border-r border-gray-200 dark:border-gray-500">
            <a
              class="relative inline-flex items-center justify-center flex-1 w-0 py-4 -mr-px text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out border border-transparent rounded-bl-lg dark:text-gray-200 hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10"
              :href="`mailto: ${props.contact.email}`"
            >
              <icon icon="mdi:envelope" class="w-5 h-5 text-gray-400" />
              <span class="ml-3">Email</span>
            </a>
          </div>
          <div class="flex flex-1 w-0 -ml-px">
            <a
              class="relative inline-flex items-center justify-center flex-1 w-0 py-4 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out border border-transparent rounded-br-lg dark:text-gray-200 hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 focus:z-10"
              :href="`tel:+${props.contact.phone}`"
            >
              <icon icon="mdi:phone" class="w-5 h-5 text-gray-400" />
              <span class="ml-3">Call</span>
            </a>
          </div>
        </div>
      </div>
    </li>
  </div>
</template>

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
const edit = () => emit('edit', {...props.contact})
</script>
