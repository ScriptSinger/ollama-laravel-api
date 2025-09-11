<script setup>
import { onMounted, computed, ref } from 'vue'

import { mdiEye, mdiTrashCan } from '@mdi/js'
import CardBoxModal from '@/components/CardBoxModal.vue'
import TableCheckboxCell from '@/components/TableCheckboxCell.vue'
import BaseLevel from '@/components/BaseLevel.vue'
import BaseButtons from '@/components/BaseButtons.vue'
import BaseButton from '@/components/BaseButton.vue'
import { useChatSessionsStore } from '@/stores/chatSessions'
import dayjs from 'dayjs'

defineProps({
  checkable: Boolean,
})

const sessionsStore = useChatSessionsStore()

onMounted(() => {
  sessionsStore.fetchSessions()
})

const items = computed(() => sessionsStore.sessions)
const selectedSession = computed(() => sessionsStore.currentSession)

// Modal
const openSessionModal = async (sessionId) => {
  await sessionsStore.fetchSessionById(sessionId)
  isModalActive.value = true
}

const isModalActive = ref(false)
const isModalDangerActive = ref(false)

const formatDate = (date) => {
  if (!date) return '—'
  return dayjs(date).format('DD.MM.YYYY HH:mm')
}

const perPage = ref(5)
const currentPage = ref(0)

const checkedRows = ref([])

const itemsPaginated = computed(() =>
  items.value.slice(perPage.value * currentPage.value, perPage.value * (currentPage.value + 1)),
)

const numPages = computed(() => Math.ceil(items.value.length / perPage.value))
const currentPageHuman = computed(() => currentPage.value + 1)

const pagesList = computed(() => {
  const pagesList = []
  for (let i = 0; i < numPages.value; i++) {
    pagesList.push(i)
  }
  return pagesList
})

const remove = (arr, cb) => arr.filter((item) => !cb(item))

const checked = (isChecked, session) => {
  if (isChecked) {
    checkedRows.value.push(session)
  } else {
    checkedRows.value = remove(checkedRows.value, (row) => row.id === session.id)
  }
}
</script>

<template>
  <!-- Модалки -->
  <CardBoxModal v-model="isModalActive" title="Session details">
    <template v-if="selectedSession">
      <h3 class="text-lg font-semibold mb-2">{{ selectedSession.title }}</h3>
      <p class="text-sm text-gray-500 mb-4">Status: {{ selectedSession.status }}</p>

      <div v-if="selectedSession.messages && selectedSession.messages.length">
        <h4 class="font-medium mb-2">Messages:</h4>
        <ul class="space-y-2">
          <li
            v-for="msg in selectedSession.messages"
            :key="msg.id"
            class="p-2 rounded border border-gray-200 dark:border-slate-700"
          >
            <strong>{{ msg.sender_type }}:</strong> {{ msg.content }}
          </li>
        </ul>
      </div>
      <div v-else>
        <em>No messages yet</em>
      </div>
    </template>
  </CardBoxModal>

  <CardBoxModal v-model="isModalDangerActive" title="Please confirm" button="danger" has-cancel>
    <p>Вы уверены, что хотите удалить сессию?</p>
  </CardBoxModal>

  <!-- Таблица -->
  <table class="min-w-full text-left border border-gray-200 dark:border-slate-700">
    <thead>
      <tr class="bg-gray-50 dark:bg-slate-800">
        <th v-if="checkable" class="px-4 py-2"></th>
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">Title</th>
        <th class="px-4 py-2">Status</th>
        <th class="px-4 py-2">Started</th>
        <th class="px-4 py-2">Ended</th>
        <th class="px-4 py-2">Created</th>
        <th class="px-4 py-2 text-right">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="session in itemsPaginated"
        :key="session.id"
        class="border-t border-gray-200 dark:border-slate-700"
      >
        <TableCheckboxCell v-if="checkable" @checked="checked($event, session)" />
        <td class="px-4 py-2">{{ session.id }}</td>
        <td class="px-4 py-2">{{ session.title }}</td>
        <td class="px-4 py-2">
          <span
            :class="[
              'px-2 py-1 rounded text-xs font-semibold',
              session.status === 'active'
                ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200'
                : 'bg-gray-200 text-gray-700 dark:bg-slate-700 dark:text-gray-300',
            ]"
          >
            {{ session.status }}
          </span>
        </td>
        <td class="px-4 py-2">{{ session.started_at }}</td>
        <td class="px-4 py-2">{{ session.ended_at ? session.ended_at : '—' }}</td>
        <td class="px-4 py-2 whitespace-nowrap">
          <small class="text-gray-500 dark:text-slate-400">{{
            formatDate(session.created_at)
          }}</small>
        </td>
        <td class="px-4 py-2 text-right">
          <BaseButtons type="justify-end" no-wrap>
            <BaseButton color="info" :icon="mdiEye" small @click="openSessionModal(session.id)" />
            <BaseButton
              color="danger"
              :icon="mdiTrashCan"
              small
              @click="isModalDangerActive = true"
            />
          </BaseButtons>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Пагинация -->
  <div class="p-3 lg:px-6 border-t border-gray-100 dark:border-slate-800">
    <BaseLevel>
      <BaseButtons>
        <BaseButton
          v-for="page in pagesList"
          :key="page"
          :active="page === currentPage"
          :label="page + 1"
          :color="page === currentPage ? 'lightDark' : 'whiteDark'"
          small
          @click="currentPage = page"
        />
      </BaseButtons>
      <small>Page {{ currentPageHuman }} of {{ numPages }}</small>
    </BaseLevel>
  </div>
</template>
