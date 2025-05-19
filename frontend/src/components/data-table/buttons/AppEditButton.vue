<template>
  <v-tooltip text="Editar" bottom>
    <template #activator="{ props }">
      <v-btn class="mx-1" icon density="comfortable" flat :loading v-bind="props" @click="action()">
        <icon-mdi-pencil class="text-lightText" />
      </v-btn>
    </template>
  </v-tooltip>
</template>

<script setup>
import { defineEmits } from 'vue'

defineProps({
  loading: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['click'])

const action = () => {
  emit('click')
}
</script>
