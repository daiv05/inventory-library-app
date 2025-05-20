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
              <!-- Nombre -->
              <v-col cols="12">
                <v-text-field
                  v-model="localProduct.nombre"
                  :rules="nombreRules"
                  label="Nombre"
                  variant="outlined"
                  density="compact"
                  required
                ></v-text-field>
              </v-col>
              <!-- Descripcion -->
              <v-col cols="12">
                <v-textarea
                  v-model="localProduct.descripcion"
                  :rules="descripcionRules"
                  label="Descripción"
                  variant="outlined"
                  density="compact"
                  rows="2"
                  auto-grow
                  required
                ></v-textarea>
              </v-col>
              <!-- Estado -->
              <v-col cols="12">
                <v-select
                  v-model="localProduct.id_estado"
                  variant="outlined"
                  label="Estado"
                  :rules="estadoRules"
                  :items="estados"
                  item-title="nombre"
                  item-value="id"
                  density="compact"
                  required
                ></v-select>
              </v-col>
            </v-row>
          </v-col>
          <v-col cols="12">
            <v-list-item>
              <span class="text-h5 text-lightText font-weight-bold">Detalles extras</span>
              <v-divider></v-divider>
            </v-list-item>
          </v-col>
          <v-col cols="12">
            <v-row class="pa-4">
              <!-- Código de producto -->
              <v-col cols="12">
                <v-text-field
                  v-model="localProduct.codigo_producto"
                  label="Código de producto"
                  variant="outlined"
                  density="compact"
                  :rules="codigoProductoRules"
                ></v-text-field>
              </v-col>
              <!-- Color -->
              <v-col cols="12">
                <v-text-field
                  v-model="localProduct.color"
                  label="Color"
                  variant="outlined"
                  density="compact"
                  :rules="colorRules"
                ></v-text-field>
              </v-col>
              <!-- Dimensiones -->
              <v-col cols="12">
                <v-text-field
                  v-model="localProduct.dimensiones"
                  label="Dimensiones"
                  variant="outlined"
                  density="compact"
                  :rules="dimensionesRules"
                ></v-text-field>
              </v-col>
              <!-- Peso -->
              <v-col cols="12">
                <v-text-field
                  v-model="localProduct.peso"
                  label="Peso"
                  variant="outlined"
                  density="compact"
                  :rules="pesoRules"
                ></v-text-field>
              </v-col>
              <!-- Material -->
              <v-col cols="12">
                <v-text-field
                  v-model="localProduct.material"
                  label="Material"
                  variant="outlined"
                  density="compact"
                  :rules="materialRules"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-col>
          <v-col cols="12">
            <v-list-item>
              <span class="text-h5 text-lightText font-weight-bold"
                >Información para libros / revistas</span
              >
              <v-divider></v-divider>
            </v-list-item>
          </v-col>
          <v-col cols="12">
            <v-row class="pa-4">
              <!-- Categoria -->
              <v-col cols="12">
                <v-select
                  v-model="localProduct.id_categoria"
                  variant="outlined"
                  label="Categoría"
                  :items="categorias"
                  item-title="nombre"
                  item-value="id"
                  density="compact"
                  clearable
                ></v-select>
              </v-col>
              <!-- Genero -->
              <v-col cols="12">
                <v-select
                  v-model="localProduct.id_genero"
                  variant="outlined"
                  label="Género"
                  :items="generos"
                  item-title="nombre"
                  item-value="id"
                  density="compact"
                  clearable
                ></v-select>
              </v-col>
              <!-- Autor -->
              <v-col cols="12">
                <v-text-field
                  v-model="localProduct.autor"
                  label="Autor"
                  variant="outlined"
                  density="compact"
                  :rules="autorRules"
                ></v-text-field>
              </v-col>
              <!-- ISBN -->
              <v-col cols="12">
                <v-text-field
                  v-model="localProduct.isbn"
                  label="ISBN"
                  variant="outlined"
                  density="compact"
                  :rules="isbnRules"
                ></v-text-field>
              </v-col>
              <!-- Año de publicación -->
              <v-col cols="12">
                <v-text-field
                  v-model="localProduct.anio_publicacion"
                  label="Año de publicación"
                  variant="outlined"
                  density="compact"
                  :rules="anioPublicacionRules"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-col>
        </v-row>
      </v-form>
    </template>
  </app-modal>
</template>

<script setup>
import estadosService from '@/services/catalogs/estados.service'
import generosService from '@/services/catalogs/generos.service'
import categoriasService from '@/services/products/categorias.service'
import { useAppStore } from '@/stores/app.store'

const { showLoader, hideLoader } = useAppStore()
const alertToast = inject('alertToast')
const emit = defineEmits(['confirmEdit'])
const props = defineProps({
  selectedProduct: {
    type: Object,
    required: true
  }
})

// Locales
const localProduct = ref({})
localProduct.value = {
  id: props.selectedProduct.id,
  nombre: props.selectedProduct.nombre,
  descripcion: props.selectedProduct.descripcion,
  id_estado: props.selectedProduct.id_estado,
  id_categoria: props.selectedProduct.id_categoria,
  id_genero: props.selectedProduct.detalle_producto?.id_genero,
  codigo_producto: props.selectedProduct.detalle_producto?.codigo_producto,
  color: props.selectedProduct.detalle_producto?.color,
  dimensiones: props.selectedProduct.detalle_producto?.dimensiones,
  peso: props.selectedProduct.detalle_producto?.peso,
  material: props.selectedProduct.detalle_producto?.material,
  isbn: props.selectedProduct.detalle_producto?.isbn,
  anio_publicacion: props.selectedProduct.detalle_producto?.anio_publicacion,
  autor: props.selectedProduct.autor
}

// Listados
const estados = ref([])
const categorias = ref([])
const generos = ref([])

// Validaciones
const validForm = ref()
const nombreRules = ref([
  (v) => !!v || 'El nombre es requerido',
  (v) => (v && v.length <= 50) || 'El nombre debe tener menos de 50 caracteres'
])
const descripcionRules = ref([
  (v) => !!v || 'La descripción es requerida',
  (v) => (v && v.length <= 200) || 'La descripción debe tener menos de 200 caracteres'
])
const estadoRules = ref([(v) => !!v || 'El estado es requerido'])
const codigoProductoRules = ref([
  (v) => !v || v.length <= 20 || 'El código de producto debe tener menos de 20 caracteres'
])
const colorRules = ref([
  (v) => !v || v.length <= 20 || 'El color debe tener menos de 20 caracteres'
])
const dimensionesRules = ref([
  (v) => !v || v.length <= 20 || 'Las dimensiones deben tener menos de 20 caracteres'
])
const pesoRules = ref([(v) => !v || v.length <= 20 || 'El peso debe tener menos de 20 caracteres'])
const materialRules = ref([
  (v) => !v || v.length <= 20 || 'El material debe tener menos de 20 caracteres'
])
const isbnRules = ref([(v) => !v || v.length <= 20 || 'El ISBN debe tener menos de 20 caracteres'])
const anioPublicacionRules = ref([
  (v) => !v || v.length <= 20 || 'El año de publicación debe tener menos de 20 caracteres'
])
const autorRules = ref([
  (v) => !v || v.length <= 20 || 'El autor debe tener menos de 20 caracteres'
])

// Servicios de listados
const getEstados = async () => {
  showLoader()
  try {
    const params = {
      scope: 'general'
    }
    const { data } = await estadosService.list(params)
    estados.value = data.data
  } catch (error) {
    alertToast({
      text: 'Error al cargar los estados',
      type: 'error'
    })
    throw error
  } finally {
    hideLoader()
  }
}

const getCategorias = async () => {
  showLoader()
  try {
    const { data } = await categoriasService.list()
    categorias.value = data.data
  } catch (error) {
    alertToast({
      text: 'Error al cargar las categorías',
      type: 'error'
    })
    throw error
  } finally {
    hideLoader()
  }
}

const getGeneros = async () => {
  showLoader()
  try {
    const { data } = await generosService.list()
    generos.value = data.data
  } catch (error) {
    alertToast({
      text: 'Error al cargar los géneros',
      type: 'error'
    })
    throw error
  } finally {
    hideLoader()
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
  emit('confirmEdit', localProduct.value)
}

await Promise.all([getEstados(), getCategorias(), getGeneros()])
</script>
