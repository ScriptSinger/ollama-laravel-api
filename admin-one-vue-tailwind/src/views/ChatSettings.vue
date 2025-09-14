<script setup>
import { reactive, onMounted } from 'vue'
import { mdiAccount } from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'
import CardBox from '@/components/CardBox.vue'

import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'

import BaseButton from '@/components/BaseButton.vue'
import BaseButtons from '@/components/BaseButtons.vue'

import LayoutAuthenticated from '@/layouts/LayoutAuthenticated.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'

import { useChatSettingsStore } from '@/stores/chatSettings'

const store = useChatSettingsStore()

const form = reactive({
  seed: 32,
  temperature: 0.7, // временный дефолт до загрузки с сервера
  tone: 'formal',
})

onMounted(async () => {
  try {
    await store.fetchSettings()
    form.temperature = store.settings.temperature
    form.seed = store.settings.seed
    form.tone = store.settings.tone
  } catch (error) {
    console.error('Error fetching settings:', error)
  }
})

const submit = async () => {
  try {
    await store.saveSettings({
      temperature: form.temperature,
      seed: form.seed,
      tone: form.tone,
    })
    console.log('Settings saved successfully')
  } catch (error) {
    console.error('Error saving settings:', error)
  }
}
</script>

<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiChatOutline" title="Settings" main />
      <CardBox is-form form @submit.prevent="submit">
        <FormField label="Seed">
          <FormControl v-model="form.seed" :icon="mdiAccount" />
        </FormField>

        <FormField label="Temperature">
          <FormControl v-model="form.temperature" :options="store.temperatureOptions" />
        </FormField>

        <template #footer>
          <BaseButtons>
            <BaseButton type="submit" color="info" label="Submit" />
            <BaseButton type="reset" color="info" outline label="Default" />
          </BaseButtons>
        </template>
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
