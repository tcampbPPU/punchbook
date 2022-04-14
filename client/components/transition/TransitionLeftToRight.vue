<template>
  <transition
    enter-active-class="transition ease-out duration-200"
    enter-class="transform -translate-x-2 opacity-0"
    enter-to-class="transform translate-x-0 opacity-100"
    leave-active-class="ease-in duration-200"
    leave-class="transform translate-x-0 opacity-100"
    leave-to-class="transform -translate-x-2 opacity-0"
    mode="out-in"
  >
    <slot />
  </transition>
</template>
