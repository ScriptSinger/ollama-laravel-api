import apiClient from './apiClient'

export function getUsers() {
  return apiClient.get('/api/users')
}
