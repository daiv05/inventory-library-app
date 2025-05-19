<template>
  <v-dialog :max-width>
    <v-card>
      <v-card-title>
        <v-spacer></v-spacer>
        <!-- <v-row class="ma-4">
            <h3>{{ title }}</h3>
        </v-row> -->
        <v-row class="mt-1" dense>
          <v-col cols="12" class="d-flex justify-end">
            <v-btn icon density="comfortable" flat @click="close">
              <icon-mdi-close></icon-mdi-close>
            </v-btn>
          </v-col>
        </v-row>
      </v-card-title>
      <v-card-text class="py-0">
        <slot name="body"></slot>
      </v-card-text>
      <v-card-actions class="px-8 pb-4">
        <v-spacer></v-spacer>
        <slot name="actions">
          <v-btn class="text-none" variant="plain" :text="cancelText" @click="close"></v-btn>
          <v-btn
            v-if="showConfirmButton"
            class="text-none"
            :color="dangerButton ? 'red' : 'secondary'"
            :text="confirmText"
            variant="tonal"
            @click="confirm"
          ></v-btn>
        </slot>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script setup>
defineProps({
  maxWidth: {
    type: String,
    default: '600px'
  },
  title: {
    type: String,
    default: 'Confirmar acción'
  },
  cancelText: {
    type: String,
    default: 'Cancelar'
  },
  confirmText: {
    type: String,
    default: 'Confirmar'
  },
  showConfirmButton: {
    type: Boolean,
    default: true
  },
  dangerButton: {
    type: Boolean,
    default: false
  },
})

const emit = defineEmits(['close', 'confirm'])
const close = () => {
  emit('close')
}
const confirm = () => {
  emit('confirm')
}
</script>
