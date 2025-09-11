<script setup>
import { ref } from 'vue'
import { mdiSend } from '@mdi/js'
import BaseIcon from '@/components/BaseIcon.vue'

const emit = defineEmits(['send'])
const message = ref('')

const sendMessage = () => {
  if (message.value.trim() === '') return
  emit('send', message.value.trim())
  message.value = ''
}

const resize = (e) => {
  const el = e.target
  el.style.height = 'auto'
  el.style.height = el.scrollHeight + 'px'
}
</script>

<template>
  <div class="flex w-full items-end gap-2">
    <textarea
      v-model="message"
      @input="resize"
      @keydown.enter.exact.prevent="sendMessage"
      placeholder="Type a message..."
      rows="1"
      class="flex-1 resize-none overflow-hidden bg-transparent border-0 focus:ring-0 focus:outline-none text-sm dark:text-slate-100"
    />
    <button
      @click="sendMessage"
      class="p-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition"
    >
      <BaseIcon :path="mdiSend" size="20" />
    </button>
  </div>
</template>
