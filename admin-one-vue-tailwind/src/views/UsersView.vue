<script setup>
import TableSampleUsers from '@/components/TableSampleUsers.vue'
import CardBox from '@/components/CardBox.vue'

import LayoutAuthenticated from '@/layouts/LayoutAuthenticated.vue'
import SectionMain from '@/components/SectionMain.vue'
</script>

<template>
  <LayoutAuthenticated>
    <SectionMain>
      <CardBox class="mb-6" has-table>
        <TableSampleUsers checkable />
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
