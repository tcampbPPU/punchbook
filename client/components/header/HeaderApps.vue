<template>
  <div class="relative flex items-center ml-6">
    <div v-if="$api.loggedIn.value">
      <button
        ref="target"
        class="p-1 rounded-full hover:ring-2 hover:ring-offset-2 hover:ring-offset-blue-300 hover:ring-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-300"
        @click="toggle"
      >
        <span class="sr-only">Browse Apps</span>
        <span class="p-0.5 w-5 h-5 grid grid-cols-3 grid-rows-3 gap-0.5">
          <span
            v-for="i in 9"
            :key="i"
            class="w-1 h-1 bg-gray-900 dark:bg-white"
          />
        </span>
      </button>
      <client-only>
        <transition-bottom-to-top>
          <header-apps-flyout v-if="flyout" @close="off" />
        </transition-bottom-to-top>
      </client-only>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { onClickOutside } from '@vueuse/core'
import TransitionBottomToTop from '~/components/transition/TransitionBottomToTop.vue'
import HeaderAppsFlyout from '~/components/header/HeaderAppsFlyout.vue'

const { $api } = useNuxtApp()
const flyout = ref(false)
const target = ref(null)

onClickOutside(target, () => off())

const toggle = () => flyout.value = !flyout.value
const off = () => flyout.value = false

</script>
