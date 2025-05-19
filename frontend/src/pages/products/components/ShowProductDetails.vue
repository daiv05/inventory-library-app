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
              <v-list-item-subtitle>{{ selectedProduct.nombre }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item>
              <v-list-item-title>Descripción</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.descripcion }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item>
              <v-list-item-title>Precio actual ($)</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.precio_actual }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item>
              <v-list-item-title>Stock actual</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.stock_actual }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item>
              <v-list-item-title>Estado</v-list-item-title>
              <v-list-item-subtitle>
                <app-status-chip :status="selectedProduct.estado.id" />
              </v-list-item-subtitle>
            </v-list-item>
          </v-list>
        </v-col>
        <v-col cols="12">
          <v-list-item>
            <span class="text-h5 text-lightText font-weight-bold">Detalles extras</span>
            <v-divider></v-divider>
          </v-list-item>
        </v-col>
        <v-col cols="12">
          <v-list>
            <v-list-item v-if="selectedProduct.categoria">
              <v-list-item-title>Categoria</v-list-item-title>
              <v-list-item-subtitle>
                <v-chip>
                  {{ selectedProduct.categoria.nombre }}
                </v-chip>
              </v-list-item-subtitle>
            </v-list-item>
            <v-list-item v-if="selectedProduct.detalle_producto.codigo_producto">
              <v-list-item-title>Código de producto</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.detalle_producto.codigo_producto }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item v-if="selectedProduct.detalle_producto.color">
              <v-list-item-title>Color</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.detalle_producto.color }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item v-if="selectedProduct.detalle_producto.dimensiones">
              <v-list-item-title>Dimensiones</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.detalle_producto.dimensiones }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item v-if="selectedProduct.detalle_producto.peso">
              <v-list-item-title>Peso</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.detalle_producto.peso }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item v-if="selectedProduct.detalle_producto.material">
              <v-list-item-title>Material</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.detalle_producto.material }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item v-if="selectedProduct.detalle_producto.isbn">
              <v-list-item-title>ISBN</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.detalle_producto.isbn }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item v-if="selectedProduct.detalle_producto.anio_publicacion">
              <v-list-item-title>Año de publicación</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.detalle_producto.anio_publicacion }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item v-if="selectedProduct.detalle_producto.autor">
              <v-list-item-title>Autor</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.autor }}</v-list-item-subtitle>
            </v-list-item>
            <v-list-item v-if="selectedProduct.detalle_producto.genero">
              <v-list-item-title>Género</v-list-item-title>
              <v-list-item-subtitle>{{ selectedProduct.detalle_producto.genero.nombre }}</v-list-item-subtitle>
            </v-list-item>
          </v-list>
        </v-col>
      </v-row>
    </template>
  </app-modal>
</template>

<script setup>
defineProps({
  selectedProduct: {
    type: Object,
    default: () => ({})
  }
})
</script>
