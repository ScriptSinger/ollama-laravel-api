<template>
  <div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Пользователи</h1>

    <div v-if="loading" class="text-gray-500">Загрузка...</div>
    <div v-if="error" class="text-red-600">{{ error }}</div>

    <table v-if="users.length" class="w-full border-collapse border border-gray-300">
      <thead>
        <tr>
          <th class="border border-gray-300 p-2">ID</th>
          <th class="border border-gray-300 p-2">Имя</th>
          <th class="border border-gray-300 p-2">Email</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id" class="hover:bg-gray-100">
          <td class="border border-gray-300 p-2">{{ user.id }}</td>
          <td class="border border-gray-300 p-2">{{ user.name }}</td>
          <td class="border border-gray-300 p-2">{{ user.email }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { getUsers } from '../api/users'

const users = ref([])
const loading = ref(false)
const error = ref(null)

async function fetchData() {
  loading.value = true
  error.value = null
  try {
    const { data } = await getUsers()
    users.value = data.data || []
  } catch (err) {
    error.value = 'Не удалось загрузить пользователей'
  } finally {
    loading.value = false
  }
}

onMounted(fetchData)
</script>
