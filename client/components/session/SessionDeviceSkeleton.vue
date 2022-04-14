<template>
  <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
    <div class="absolute top-0 right-0 m-2">
      <push-button theme="text" size="xs" class="shadow-none">
        <icon-client
          icon="mdi-trash"
          class="w-4 h-4 text-gray-200"
        />
      </push-button>
    </div>
    <div class="flex items-center justify-center py-4 border-b border-gray-200">
      <div class="skeleton" style="width: 72px; height: 72px;" />
    </div>
    <div class="p-4">
      <div>
        <div class="flex items-center mb-1 text-gray-900">
          <icon-client
            icon="mdi-laptop"
            class="w-4 h-4 mr-1.5 text-gray-200"
          />
          <div class="w-32 skeleton">
            &nbsp;
          </div>
        </div>
        <div class="flex items-center mb-1 text-sm text-gray-500">
          <icon-client
            icon="mdi-application-outline"
            class="w-4 h-4 mr-1.5 text-gray-200"
          />
          <div class="w-32 skeleton">
            &nbsp;
          </div>
        </div>
        <div class="flex items-center mb-1 text-sm text-gray-500">
          <icon-client
            icon="mdi-map"
            class="w-4 h-4 mr-1.5 text-gray-200"
          />
          <div class="w-20 skeleton">
            &nbsp;
          </div>
        </div>
        <div class="flex items-center mb-1 text-sm text-gray-500">
          <icon-client
            icon="mdi-envelope"
            class="w-4 h-4 mr-1.5 text-gray-200"
          />
          <div class="w-20 skeleton">
            &nbsp;
          </div>
        </div>
        <div class="flex items-center mb-1 text-sm text-gray-500">
          <icon-client
            icon="mdi-clock"
            class="w-4 h-4 mr-1.5 text-gray-200"
          />
          <div class="w-14 skeleton">
            &nbsp;
          </div>
        </div>
        <div class="flex items-center mb-1 text-sm text-gray-500">
          <icon-client
            icon="mdi-clock"
            class="w-4 h-4 mr-1.5 text-gray-200"
          />
          <div class="w-14 skeleton">
            &nbsp;
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { PushButton } from 'tailvue'
import IconClient from '~/components/IconClient.vue'
</script>
