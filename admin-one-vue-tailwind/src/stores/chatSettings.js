import { defineStore } from 'pinia'
import apiClient from '@/services/apiClient'
// import { c } from 'vite/dist/node/moduleRunnerTransport.d-DJ_mE5sf'

export const useChatSettingsStore = defineStore('chatSettings', {
  state: () => ({
    settings: {}, // { temperature: '1', seed: '42', tone: 'formal' }
    loading: false,
  }),

  actions: {
    async fetchSettings() {
      this.loading = true
      try {
        const res = await apiClient.get('/api/settings')
        this.settings = res.data
        return res.data
      } catch (error) {
        console.error('Failed to fetch settings:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    async saveSettings(payload) {
      this.loading = true
      try {
        const res = await apiClient.post('/api/settings', payload)
        this.settings = res.data
        return res.data
      } catch (error) {
        console.error('Failed to save settings:', error)
        throw error
      } finally {
        this.loading = false
      }
    },
  },

  getters: {
    temperatureOptions: () => {
      return [
        { label: '0.3 — низкая креативность', value: 0.3 },
        { label: '0.5 — умеренная креативность', value: 0.5 },
        { label: '0.7 — стандартная креативность', value: 0.7 },
        { label: '0.9 — высокая креативность', value: 0.9 },
      ]
    },
  },
})
