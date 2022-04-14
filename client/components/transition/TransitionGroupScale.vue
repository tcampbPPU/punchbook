<template>
  <transition-group
    enter-active-class="transition ease-out duration-200"
    enter-class="transform scale-95 opacity-0"
    enter-to-class="transform scale-100 opacity-100"
    leave-active-class="ease-in duration-200"
    leave-class="transform scale-100 opacity-100"
    leave-to-class="transform scale-110 opacity-0"
  >
    <slot />
  </transition-group>
</template>
