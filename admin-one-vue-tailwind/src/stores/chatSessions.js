import { defineStore } from 'pinia'
import apiClient from '@/services/apiClient'

// простая нормализация: убираем кавычки, знаки препинания и лишние пробелы
function normalizeTitle(title) {
  if (!title) return ''
  return title.replace(/["'.,!?;:]/g, '').trim()
}

export const useChatSessionsStore = defineStore('chatSessions', {
  state: () => ({
    sessions: [],
    currentSession: null, // конкретная выбранная сессия
    loading: false,
    messages: [], // <-- сюда будем хранить чаты текущей сессии
  }),
  actions: {
    async fetchSessions() {
      this.loading = true
      try {
        const res = await apiClient.get('/api/chat-sessions')
        this.sessions = res.data.map((s) => ({
          ...s,
          title: normalizeTitle(s.title),
        }))
      } finally {
        this.loading = false
      }
    },
    async fetchSessionById(id) {
      this.loading = true
      try {
        const res = await apiClient.get(`/api/chat-sessions/${id}`)
        this.currentSession = res.data
        return res.data
      } finally {
        this.loading = false
      }
    },
    async createSession(payload) {
      this.loading = true
      try {
        console.log('Creating new chat session with payload:', payload)
        const res = await apiClient.post('/api/chat-sessions', payload)
        this.sessions.push(res.data) // добавляем новую сессию в store
        return res.data
      } finally {
        this.loading = false
      }
    },
    async fetchMessages(sessionId) {
      this.loading = true
      try {
        const res = await apiClient.get(`/api/chat-sessions/${sessionId}/messages`)
        this.messages = res.data
        console.log('Fetched messages:', this.messages)
        return res.data
      } finally {
        this.loading = false
      }
    },
  },
})
