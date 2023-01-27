<script lang="ts" setup>
import { Icon } from '@iconify/vue'
import { PushButton } from 'tailvue'
</script>

<template>
  <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
    <div class="absolute top-0 right-0 m-2">
      <PushButton theme="text" size="xs" class="shadow-none">
        <Icon icon="mdi-trash" class="w-4 h-4 text-gray-200" />
      </PushButton>
    </div>
    <div class="flex items-center justify-center py-4 border-b border-gray-200">
      <div class="skeleton" style="width: 72px; height: 72px"></div>
    </div>
    <div class="p-4">
      <div>
        <div class="flex items-center mb-1 text-gray-900">
          <Icon icon="mdi-laptop" class="w-4 h-4 mr-1.5 text-gray-200" />
          <div class="w-32 skeleton">
&nbsp;
          </div>
        </div>
        <div class="flex items-center mb-1 text-sm text-gray-500">
          <Icon
            icon="mdi-application-outline"
            class="w-4 h-4 mr-1.5 text-gray-200"
          />
          <div class="w-32 skeleton">
&nbsp;
          </div>
        </div>
        <div class="flex items-center mb-1 text-sm text-gray-500">
          <Icon icon="mdi-map" class="w-4 h-4 mr-1.5 text-gray-200" />
          <div class="w-20 skeleton">
&nbsp;
          </div>
        </div>
        <div class="flex items-center mb-1 text-sm text-gray-500">
          <Icon icon="mdi-envelope" class="w-4 h-4 mr-1.5 text-gray-200" />
          <div class="w-20 skeleton">
&nbsp;
          </div>
        </div>
        <div class="flex items-center mb-1 text-sm text-gray-500">
          <Icon icon="mdi-clock" class="w-4 h-4 mr-1.5 text-gray-200" />
          <div class="w-14 skeleton">
&nbsp;
          </div>
        </div>
        <div class="flex items-center mb-1 text-sm text-gray-500">
          <Icon icon="mdi-clock" class="w-4 h-4 mr-1.5 text-gray-200" />
          <div class="w-14 skeleton">
&nbsp;
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
