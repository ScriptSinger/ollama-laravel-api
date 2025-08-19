// stores/auth.js
import { defineStore } from 'pinia'
import * as authService from '@/services/auth'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null, // сюда будем сохранять данные пользователя
  }),
  actions: {
    async login(email, password, remember = false) {
      const data = await authService.login(email, password, remember)
      this.user = data.user // сохраняем пользователя в store
      return data
    },
    async logout() {
      await authService.logout()
      this.user = null // очищаем пользователя
    },
  },
})
