<script setup>
import { useAuthStore } from '@/stores/auth.store'
import { OverlayScrollbarsComponent } from 'overlayscrollbars-vue'
import { storeToRefs } from 'pinia'

const authStore = useAuthStore()
const { user } = storeToRefs(authStore)
const closeSession = async () => {
  await authStore.logout()
}
</script>

<template>
  <div class="pa-4">
    <h4 class="mb-n1">
      Bienvenido, <span class="font-weight-regular">{{ user.username }}</span>
    </h4>
    <span class="text-subtitle-2 text-medium-emphasis">{{ user.role }}</span>

    <v-divider></v-divider>

    <OverlayScrollbarsComponent
      element="span"
      :options="{ scrollbars: { autoHide: 'scroll' } }"
      defer
      class="position-relative"
      style="height: calc(100vh - 300px); max-height: 515px"
    >
      <v-divider></v-divider>

      <div class="bg-lightPrimary rounded-lg px-5 py-3 my-3">
        <div class="d-flex align-center justify-space-between">
          <h5 class="text-h5">Modo oscuro</h5>
          <AppSwitchTheme />
        </div>
      </div>

      <v-divider></v-divider>

      <v-list class="bottom-0 right-0 position-absolute">
        <v-list-item color="secondary" rounded="md" @click="closeSession()">
          <template #prepend>
            <icon-mdi-logout class="ml mr-8" />
          </template>
          <v-list-item-title class="text-subtitle-2"> Cerrar sesión</v-list-item-title>
        </v-list-item>
      </v-list>
    </OverlayScrollbarsComponent>
  </div>
</template>
