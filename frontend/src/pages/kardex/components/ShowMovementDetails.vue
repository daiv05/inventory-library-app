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
            <!-- Tipo de movimiento -->
            <v-list-item>
              <v-list-item-title>Tipo de movimiento</v-list-item-title>
              <v-list-item-subtitle>{{
                selectedCategory.tipo_movimiento.nombre
              }}</v-list-item-subtitle>
            </v-list-item>
            <!-- Producto afectado -->
            <v-list-item>
              <v-list-item-title>Producto afectado</v-list-item-title>
              <v-list-item-subtitle>{{ selectedCategory.producto.nombre }}</v-list-item-subtitle>
              <v-list-item-subtitle>
                {{ selectedCategory.producto.descripcion }}
              </v-list-item-subtitle>
            </v-list-item>
            <!-- Cantidad -->
            <v-list-item>
              <v-list-item-title>Cantidad</v-list-item-title>
              <v-list-item-subtitle>{{ selectedCategory.cantidad }}</v-list-item-subtitle>
            </v-list-item>
            <!-- Precio unitario -->
            <v-list-item>
              <v-list-item-title>Precio unitario</v-list-item-title>
              <v-list-item-subtitle>${{ selectedCategory.precio_unitario }}</v-list-item-subtitle>
            </v-list-item>
            <!-- Observaciones -->
            <v-list-item>
              <v-list-item-title>Observaciones</v-list-item-title>
              <v-list-item-subtitle>{{ selectedCategory.observaciones }}</v-list-item-subtitle>
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
