<template>
  <v-row class="d-flex align-center justify-center h-screen">
    <v-col cols="12" class="d-block justify-center">
      <v-img class="mx-auto my-6" max-width="228" :src="library"></v-img>
      <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="448" rounded="lg">
        <div class="text-subtitle-1 text-medium-emphasis">Correo electrónico</div>
        <v-text-field
          v-model="email"
          density="compact"
          placeholder="Ingresa tu correo electrónico"
          variant="outlined"
        >
          <template #prepend-inner>
            <icon-mdi-email-outline
              class="text-medium-emphasis"
              color="currentColor"
            ></icon-mdi-email-outline>
          </template>
        </v-text-field>
        <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
          Contraseña
        </div>
        <v-text-field
          v-model="password"
          :type="visible ? 'text' : 'password'"
          density="compact"
          placeholder="Ingresa tu contraseña"
          variant="outlined"
        >
          <template #prepend-inner>
            <icon-mdi-lock-outline
              class="text-medium-emphasis"
              color="currentColor"
            ></icon-mdi-lock-outline>
          </template>
          <template #append-inner>
            <icon-mdi-eye
              v-if="visible"
              class="text-medium-emphasis"
              color="currentColor"
              @click="visible = !visible"
            ></icon-mdi-eye>
            <icon-mdi-eye-off
              v-else
              class="text-medium-emphasis"
              color="currentColor"
              @click="visible = !visible"
            ></icon-mdi-eye-off>
          </template>
        </v-text-field>
        <v-btn
          class="mb-8 font-weight-bold text-none"
          color="primary"
          size="large"
          variant="tonal"
          block
          @click="loginLocal"
        >
          Iniciar sesión
        </v-btn>
      </v-card>
    </v-col>
  </v-row>
</template>

<script setup>
import { ref, inject } from 'vue'
import library from '@/assets/icons/library.png'
import { useAuthStore } from '@/stores/auth.store'

const alertToast = inject('alertToast')
const { login } = useAuthStore()

const visible = ref(false)

const email = ref('')
const password = ref('')

const loginLocal = async () => {
  if (!email.value || !password.value) {
    alertToast({
      title: 'Error',
      text: 'Por favor, ingrese su correo electrónico y contraseña',
      type: 'error'
    })
    return
  }
  await login(email.value, password.value)
}
</script>
