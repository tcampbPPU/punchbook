<template>
  <div class="relative flex-shrink-0 mr-5">
    <div class="flex items-center space-x-4 text-white">
      <push-button v-if="!$api.loggedIn.value" theme="indigo" @click="login"> Sign In </push-button>
      <button
        v-else
        id="user-menu-button"
        type="button"
        class="flex items-center max-w-xs text-sm bg-blue-300 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300"
        aria-expanded="false"
        aria-haspopup="true"
        @click="toggle"
      >
        <span class="sr-only">Open user menu</span>
        <client-only>
          <img class="w-8 h-8 bg-blue-400 rounded-full" :src="$api.$user?.avatar" alt="User Avatar">
          <template #fallback>
            <div class="w-8 h-8 bg-blue-400 rounded-full" />
          </template>
        </client-only>
      </button>
    </div>
    <client-only>
      <transition-scale-in>
        <div
          v-if="profile"
          ref="target"
          class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none"
        >
          <header-profile-menu @off="toggle" />
        </div>
      </transition-scale-in>
    </client-only>
  </div>
  <modal-base v-if="modal" :destroyed="off">
    <header-login-modal @off="off" />
  </modal-base>
</template>

<script lang="ts" setup>
import { onClickOutside } from '@vueuse/core'
import { ModalBase, PushButton } from 'tailvue'
import { ref } from '@vue/reactivity'
import HeaderLoginModal from '~/components/header/HeaderLoginModal.vue'
import TransitionScaleIn from '~/components/transition/TransitionScaleIn.vue'
import HeaderProfileMenu from '~/components/header/HeaderProfileMenu.vue'

const { $api } = useNuxtApp()
const modal = ref(false)
const profile = ref(false)
const target = ref(null)

onClickOutside(target, () => profile.value = false)

const toggle = () => profile.value = !profile.value
const login = () =>  modal.value = true
const off = () => modal.value = false

</script>
