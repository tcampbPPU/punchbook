<template>
  <transition
    mode="out-in"
    enter-active-class="transition ease-out duration-200"
    enter-class="transform -translate-y-2 opacity-0"
    enter-to-class="transform translate-y-0 opacity-100"
    leave-active-class="ease-in duration-200"
    leave-class="transform translate-y-0 opacity-100"
    leave-to-class="transform translate-y-2 opacity-0"
  >
    <slot></slot>
  </transition>
</template>
