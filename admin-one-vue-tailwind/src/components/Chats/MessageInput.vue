<script setup>
import { ref } from 'vue'

const props = defineProps({
  chatSessionId: {
    type: Number,
    required: true,
  },
})

const emit = defineEmits(['send'])

// Отправка сообщения
function sendMessage() {
  if (!message.value.trim()) return
  emit('send', {
    chat_session_id: props.chatSessionId,
    content: message.value,
  })
  message.value = '' // очищаем поле
}
// Локальное состояние
const message = ref('')
</script>

<template>
  <form @submit.prevent="sendMessage" class="flex w-full">
    <input
      v-model="message"
      type="text"
      class="flex-1 px-3 py-2 rounded-l-lg border border-gray-300 dark:border-slate-700 dark:bg-slate-900"
    />
    <button
      type="submit"
      class="px-4 py-2 rounded-r-lg bg-blue-500 text-white hover:bg-blue-600 cursor-pointer"
    >
      Отправить
    </button>
  </form>
</template>
