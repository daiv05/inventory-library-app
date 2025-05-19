<template>
  <AppBreadcrumb :title="title" :breadcrumbs="breadcrumbs"></AppBreadcrumb>
  <v-row>
    <v-col cols="12">
      <AppBaseCard title="Listado">
        <v-row class="mb-4">
          <v-col cols="12" class="d-flex justify-end">
            <v-btn class="text-none" elevation="0" color="primary" @click="registerMovement()">
              Registrar movimiento
            </v-btn>
          </v-col>
        </v-row>
        <AppDataTable
          :headers="headers"
          :items="movements"
          :loading="loading"
        >
          <template #item.actions="{ item }">
            <app-show-button @click="showMovementDetails(item, 'show')" />
          </template>
        </AppDataTable>
        <AppPagination
          v-model:page="page"
          :items-per-page="itemsPerPage"
          :total-pages="totalPages"
          position="center"
        />
      </AppBaseCard>
    </v-col>
  </v-row>

  <ShowMovementDetails
    v-model="showModalMovementDetails"
    :selected-category="selectedMovement"
    :show-confirm-button="false"
    cancel-text="Cerrar"
    @close="showModalMovementDetails = false"
  />

  <RegisterMovement
    v-if="showModalCreateMovement"
    v-model="showModalCreateMovement"
    :selected-category="selectedMovement"
    cancel-text="Cancelar"
    confirm-text="Crear"
    @close="showModalCreateMovement = false"
    @confirm-create="crearMovimiento"
  />
</template>

<script setup>
import { ref } from 'vue'
import movementsServices from '@/services/inventory/movements.service'
import ShowMovementDetails from '../components/ShowMovementDetails.vue'
import RegisterMovement from '../components/RegisterMovement.vue'
import { useAppStore } from '@/stores/app.store'

const { showLoader, hideLoader } = useAppStore()
const alertToast = inject('alertToast')

const title = 'Gestión de Movimientos de Inventario'
const breadcrumbs = [
  {
    title: 'Inventario',
    disable: true,
    href: '#'
  }
]
const headers = [
  { title: 'ID', value: 'id' },
  { title: 'Movimiento', value: 'tipo_movimiento.nombre' },
  { title: 'Producto', value: 'producto.nombre' },
  { title: 'Cantidad', value: 'cantidad' },
  { title: 'Precio ($)', value: 'precio_unitario' },
  { title: 'Acciones', value: 'actions', sortable: false, align: 'center' }
]
const movements = ref([])
const selectedMovement = ref(null)
const actionItem = ref(null)
const loading = ref(false)
const totalPages = ref(0)
const page = ref(1)
const itemsPerPage = ref(10)

const showModalMovementDetails = ref(false)
const showModalCreateMovement = ref(false)

const getMovements = async () => {
  loading.value = true
  try {
    const filters = {
      page: page.value,
      per_page: itemsPerPage.value
    }
    const { data, error } = await movementsServices.list(filters)
    if (error) {
      alertToast({
        text: error,
        type: 'error'
      })
      return
    }
    movements.value = data.data
    totalPages.value = data.pagination.totalPages
    page.value = data.pagination.page
  } catch (_error) {
    alertToast({
      text: 'Error al cargar los movimientos',
      type: 'error'
    })
  } finally {
    loading.value = false
  }
}

const showMovementDetails = async (item, action) => {
  showLoader()
  actionItem.value = action
  try {
    const { id } = item
    const { data, error } = await movementsServices.details(id)
    if (error) {
      alertToast({
        text: error,
        type: 'error'
      })
      return
    }
    selectedMovement.value = data.data
    showModalMovementDetails.value = true
  } catch (_error) {
    alertToast({
      text: 'Error al cargar los detalles del movimiento',
      type: 'error'
    })
  } finally {
    hideLoader()
  }
}

const crearMovimiento = async (item) => {
  showLoader()
  try {
    const dataItem = Object.keys(item).reduce((acc, key) => {
      if (item[key]) {
        acc[key] = item[key]
      }
      return acc
    }, {})
    const { error } = await movementsServices.create(dataItem)
    if (error) {
      alertToast({
        text: error,
        type: 'error'
      })
      return
    }
    alertToast({
      text: 'Movimiento creado correctamente',
      type: 'success'
    })
    showModalCreateMovement.value = false
    getMovements()
  } catch (_error) {
    alertToast({
      text: 'Error al crear el movimiento',
      type: 'error'
    })
  } finally {
    hideLoader()
  }
}

const registerMovement = () => {
  selectedMovement.value = null
  showModalCreateMovement.value = true
}

watch(page, () => {
  getMovements();
});

await getMovements()
</script>
