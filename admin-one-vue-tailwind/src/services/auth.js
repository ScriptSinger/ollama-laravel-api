import apiClient from './apiClient'

export function getCsrfCookie() {
  return apiClient.get('/sanctum/csrf-cookie')
}

export async function login(email, password, remember = false) {
  await getCsrfCookie()
  const response = await apiClient.post('/login', {
    email,
    password,
    remember,
  })
  return response.data
}

export function logout() {
  return apiClient.post('/logout')
}
