<template>
  <v-chip :color="statusColor" class="ma-1" rounded="lg" :style="{ width: 'fit-content' }">
    {{ statusName }}
  </v-chip>
</template>

<script setup>
import chipsColors from '@/utils/status/chips-colors'
const props = defineProps({
  status: {
    type: [String, Number],
    required: true
  }
})
const { statusColor, statusName } = chipsColors[props.status]
</script>
