import axios from 'axios'
axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || 'http://localhost', // backend
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
})

export default apiClient
