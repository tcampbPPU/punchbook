<template>
  <transition
    mode="out-in"
    enter-active-class="transition duration-200 ease-out"
    enter-class="transform translate-y-2 opacity-0"
    enter-to-class="transform translate-y-0 opacity-100"
    leave-active-class="duration-200 ease-in"
    leave-class="transform translate-y-0 opacity-100"
    leave-to-class="transform translate-y-2 opacity-0"
  >
    <slot />
  </transition>
</template>
