<template>
  <v-row>
    <v-col cols="12">
      <AppBaseCard class="my-4 rounded-lg" flat>
        <template #title>
          <h3 class="text-h3 font-weight-bold">Sistema de gestión de inventario</h3>
        </template>
        <p></p>
        <p>
          Gestiona tu inventario de manera eficiente y sencilla con DV Library. Esta aplicación está
          diseñada para facilitar la administración de productos y stock, permitiendo un seguimiento
          detallado de cada aspecto del inventario.
        </p>
      </AppBaseCard>
    </v-col>
  </v-row>
</template>

<script setup>
// Prueba del uso de <Suspense> y la pantalla de carga
await new Promise((resolve) => setTimeout(resolve, 1500))
</script>
