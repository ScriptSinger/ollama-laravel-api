<script setup>
import { mdiChatOutline } from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import { watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'

import { useChatSessionsStore } from '@/stores/chatSessions'
import CardBox from '@/components/CardBox.vue'
import LayoutAuthenticated from '@/layouts/LayoutAuthenticated.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'
import ChatInputBar from '@/components/Chats/ChatInputBar.vue'
import MessageInput from '@/components/Chats/MessageInput.vue'

const layoutAsidePadding = 'xl:pl-60'

const route = useRoute()
const chatSessionsStore = useChatSessionsStore()

const fetchSessionMessages = async (id) => {
  if (!id) return
  await chatSessionsStore.fetchMessages(id)
}

// загрузка при первом маунте
onMounted(() => {
  fetchSessionMessages(route.params.id)
})

// следим за изменением route.params.id
watch(
  () => route.params.id,
  (newId) => {
    fetchSessionMessages(newId)
  },
)
</script>

<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiChatOutline" title="Chat" main />

      <CardBox class="p-4" :hasComponentLayout="true">
        <div class="flex flex-col space-y-4">
          <div
            v-for="message in chatSessionsStore.messages"
            :key="message.id"
            :class="[
              message.sender_type === 'ai'
                ? 'self-start w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-lg px-6 py-4 shadow-sm'
                : 'self-end max-w-[60%] bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-2xl px-4 py-3 shadow-md',
            ]"
          >
            {{ message.content }}
          </div>
        </div>
      </CardBox>

      <ChatInputBar :class="layoutAsidePadding">
        <MessageInput
          :chatSessionId="Number(route.params.id)"
          @send="chatSessionsStore.sendMessage"
        />
      </ChatInputBar>
    </SectionMain>
  </LayoutAuthenticated>
</template>
