<template>
  <app-modal :max-width="'600px'" @confirm="validar()">
    <template #body>
      <v-form ref="validForm">
        <v-row dense>
          <v-col cols="12">
            <v-list-item>
              <span class="text-h5 text-lightText font-weight-bold">Información general</span>
              <v-divider></v-divider>
            </v-list-item>
          </v-col>
          <v-col cols="12">
            <v-row class="pa-4">
              <!-- Tipo de movimiento -->
              <v-col cols="12">
                <v-select
                  v-model="localMovement.id_tipo_movimiento"
                  variant="outlined"
                  label="Tipo de movimiento"
                  :rules="tipoMovimientoRules"
                  :items="tiposMovimientos"
                  item-title="nombre"
                  item-value="id"
                  density="compact"
                  required
                ></v-select>
              </v-col>
              <!-- Producto afectado -->
              <v-col cols="12">
                <v-autocomplete
                  v-model="localMovement.id_producto"
                  variant="outlined"
                  label="Producto afectado"
                  :rules="productoRules"
                  :items="productos"
                  :loading="loadingSearchProducts"
                  item-title="nombre"
                  item-value="id"
                  density="compact"
                  required
                  no-data-text="No se encontraron resultados"
                  @update:search="searchProducto"
                ></v-autocomplete>
              </v-col>
              <!-- Cantidad -->
              <v-col cols="12">
                <v-text-field
                  v-model="localMovement.cantidad"
                  variant="outlined"
                  label="Cantidad"
                  :rules="cantidadRules"
                  type="number"
                  density="compact"
                  required
                ></v-text-field>
              </v-col>
              <!-- Precio unitario -->
              <v-col cols="12">
                <v-text-field
                  v-model="localMovement.precio_unitario"
                  variant="outlined"
                  label="Precio unitario"
                  :rules="precioUnitarioRules"
                  type="number"
                  density="compact"
                  required
                ></v-text-field>
              </v-col>
              <!-- Observaciones -->
              <v-col cols="12">
                <v-textarea
                  v-model="localMovement.observaciones"
                  variant="outlined"
                  label="Observaciones"
                  :rules="observacionesRules"
                  density="compact"
                  rows="2"
                ></v-textarea>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-form>
    </template>
  </app-modal>
</template>

<script setup>
import tiposMovimientosService from '@/services/catalogs/tiposMovimientos.service'
import productsService from '@/services/products/products.service'

import { useAppStore } from '@/stores/app.store'

const { showLoader, hideLoader } = useAppStore()
const alertToast = inject('alertToast')
const emit = defineEmits(['confirmCreate'])

// Locales
const localMovement = ref({})
localMovement.value = {
  id: null,
  nombre: '',
  descripcion: '',
  id_estado: null
}

// Listados
const tiposMovimientos = ref([])
const productos = ref([])
const productSearchTimeout = ref(null)
const loadingSearchProducts = ref(false)

// Validaciones
const validForm = ref()
const tipoMovimientoRules = [(v) => !!v || 'Tipo de movimiento es requerido']
const productoRules = [(v) => !!v || 'Producto afectado es requerido']
const cantidadRules = [
  (v) => !!v || 'Cantidad es requerida',
  (v) => v > 0 || 'Cantidad debe ser mayor a 0',
  (v) => v % 1 === 0 || 'Cantidad debe ser un número entero',
  (v) => v <= 1000000000 || 'Cantidad no puede ser mayor a 1000000000'
]
const precioUnitarioRules = [
  (v) => !!v || 'Precio unitario es requerido',
  (v) => v > 0 || 'Precio unitario debe ser mayor a 0',
  (v) => v <= 1000000000 || 'Cantidad no puede ser mayor a 1000000000'
]
const observacionesRules = [(v) => !!v || 'Observaciones son requeridas']

// Servicios de listados
const getTiposMovimientos = async () => {
  showLoader()
  try {
    const { data } = await tiposMovimientosService.list()
    tiposMovimientos.value = data.data
  } catch (error) {
    alertToast({
      text: 'Error al cargar los tipos de movimientos',
      type: 'error'
    })
    throw error
  } finally {
    hideLoader()
  }
}

const searchProducto = async (query) => {
  productSearchTimeout.value && clearTimeout(productSearchTimeout.value)
  productSearchTimeout.value = setTimeout(async () => {
    if (query.length < 3) {
      productos.value = []
      return
    }
    await getProductos(query)
  }, 800)
}

const getProductos = async (query) => {
  loadingSearchProducts.value = true
  try {
    const params = {
      query: query
    }
    const { data } = await productsService.search(params)
    productos.value = data.data
  } catch (error) {
    alertToast({
      text: 'Error al cargar los productos',
      type: 'error'
    })
    throw error
  } finally {
    loadingSearchProducts.value = false
  }
}

const validar = async () => {
  const { valid } = await validForm.value.validate()
  if (!valid) {
    alertToast({
      text: 'Por favor, completa todos los campos requeridos',
      type: 'error'
    })
    return
  }
  emit('confirmCreate', localMovement.value)
}

await getTiposMovimientos()
</script>
