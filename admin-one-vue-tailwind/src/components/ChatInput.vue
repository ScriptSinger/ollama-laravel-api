<script setup>
import { containerMaxW } from '@/config.js'

// const isMenuNavBarActive = ref(false)
</script>

<template>
  <div
    class="bottom-10 inset-x-0 fixed bg-gray-50 h-14 z-30 transition-position w-screen lg:w-auto dark:bg-slate-800"
  >
    <div class="flex lg:items-stretch" :class="containerMaxW">
      <div class="flex flex-1 items-stretch h-14">
        <slot />
      </div>
    </div>
  </div>
</template>
