<script setup>
import { ref, onMounted } from 'vue'
import { getUsers } from '../services/users'
import LayoutAuthenticated from '@/layouts/LayoutAuthenticated.vue'
import SectionMain from '@/components/SectionMain.vue'

const users = ref([])

async function fetchData() {
  const response = await getUsers()
  users.value = response.data
}

onMounted(fetchData)
</script>

<template>
  <LayoutAuthenticated>
    <SectionMain>
      <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Пользователи</h1>

        <table class="w-full border-collapse border border-gray-300">
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
    </SectionMain>
  </LayoutAuthenticated>
</template>
