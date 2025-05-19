<template>
  <app-modal :max-width="'600px'">
    <template #body>
      <v-row dense>
        <v-col cols="12">
          <v-list-item>
            <span class="text-h5 text-lightText font-weight-bold">Información general</span>
            <v-divider></v-divider>
          </v-list-item>
        </v-col>
        <v-col cols="12">
          <v-list class="pa-0">
            <v-list-item>
              <v-list-item-title>Nombre</v-list-item-title>
              <v-list-item-subtitle>{{ selectedCategory.nombre }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item>
              <v-list-item-title>Descripción</v-list-item-title>
              <v-list-item-subtitle>{{ selectedCategory.descripcion }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item>
              <v-list-item-title>Estado</v-list-item-title>
              <v-list-item-subtitle>
                <app-status-chip :status="selectedCategory.estado.id" />
              </v-list-item-subtitle>
            </v-list-item>
          </v-list>
        </v-col>
      </v-row>
    </template>
  </app-modal>
</template>

<script setup>
defineProps({
  selectedCategory: {
    type: Object,
    default: () => ({})
  }
})
</script>
