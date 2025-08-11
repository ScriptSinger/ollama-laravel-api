<template>
  <div class="mistral-form">
    <h2>Mistral Query</h2>
    <form @submit.prevent="handleSubmit">
      <textarea
        v-model="prompt"
        placeholder="Введите prompt"
        rows="4"
      ></textarea>
      <button type="submit" :disabled="loading">
        {{ loading ? "Отправка..." : "Отправить" }}
      </button>
    </form>

    <div v-if="error" class="error">Ошибка: {{ error }}</div>
    <div v-if="result" class="result"><strong>Ответ:</strong> {{ result }}</div>
  </div>
</template>

<script>
import { ref } from "vue";
import { testApi } from "../api/mistralApi";

export default {
  setup() {
    const prompt = ref("");
    const result = ref(null);
    const loading = ref(false);
    const error = ref(null);

    async function handleSubmit() {
      loading.value = true;
      error.value = null;
      result.value = null;
      try {
        const data = await testApi(prompt.value);
        console.log("API response:", data);
        result.value = data.response || "";
      } catch (e) {
        error.value = e.message || "Неизвестная ошибка";
      } finally {
        loading.value = false;
      }
    }

    return { prompt, result, loading, error, handleSubmit };
  },
};
</script>

<style scoped>
.mistral-form {
  max-width: 500px;
  margin: auto;
}
textarea {
  width: 100%;
  margin-bottom: 8px;
}
button {
  padding: 6px 12px;
}
.error {
  color: red;
  margin-top: 10px;
}
.result {
  margin-top: 12px;
  padding: 8px;
  background: #f2f2f2;
}
</style>
