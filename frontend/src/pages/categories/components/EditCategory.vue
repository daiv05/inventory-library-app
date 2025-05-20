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
                  v-model="localCategory.nombre"
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
                  v-model="localCategory.descripcion"
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
                  v-model="localCategory.id_estado"
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
        </v-row>
      </v-form>
    </template>
  </app-modal>
</template>

<script setup>
import estadosService from '@/services/catalogs/estados.service'
import { useAppStore } from '@/stores/app.store'

const { showLoader, hideLoader } = useAppStore()
const alertToast = inject('alertToast')
const emit = defineEmits(['confirmEdit'])

const props = defineProps({
  selectedCategory: {
    type: Object,
    default: () => ({})
  }
})

// Locales
const localCategory = ref({})
localCategory.value = {
  id: props.selectedCategory.id || null,
  nombre: props.selectedCategory.nombre || '',
  descripcion: props.selectedCategory.descripcion || '',
  id_estado: props.selectedCategory.id_estado || null
}

// Listados
const estados = ref([])

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

const validar = async () => {
  const { valid } = await validForm.value.validate()
  if (!valid) {
    alertToast({
      text: 'Por favor, completa todos los campos requeridos',
      type: 'error'
    })
    return
  }
  emit('confirmEdit', localCategory.value)
}

await getEstados()
</script>
