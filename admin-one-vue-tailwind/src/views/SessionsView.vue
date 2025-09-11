<script setup>
import { mdiTableBorder } from '@mdi/js'
import SectionMain from '@/components/SectionMain.vue'

// import TableSampleClients from '@/components/TableSampleClients.vue'
import CardBox from '@/components/CardBox.vue'
import LayoutAuthenticated from '@/layouts/LayoutAuthenticated.vue'
import SectionTitleLineWithButton from '@/components/SectionTitleLineWithButton.vue'

import SessionTable from '@/components/Sessions/SessionsTable.vue'
</script>

<template>
  <LayoutAuthenticated>
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiTableBorder" title="Sessions" main>
      </SectionTitleLineWithButton>

      <CardBox class="mb-6" has-table>
        <SessionTable checkable />
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
