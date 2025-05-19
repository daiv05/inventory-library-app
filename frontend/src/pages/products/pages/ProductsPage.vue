<template>
  <AppBreadcrumb :title="title" :breadcrumbs="breadcrumbs"></AppBreadcrumb>
  <v-row>
    <v-col cols="12">
      <AppBaseCard title="Listado">
        <v-row class="mb-4">
          <v-col cols="12" class="d-flex justify-end">
            <v-btn class="text-none" elevation="0" color="primary" @click="createProduct()">
              Registrar producto
            </v-btn>
          </v-col>
        </v-row>
        <AppDataTable
          :headers="headers"
          :items="products"
          :loading="loading"
        >
          <template #item.estado="{ item }">
            <app-status-chip :status="item.estado.id" />
          </template>
          <template #item.actions="{ item }">
            <app-show-button @click="showProductDetails(item, 'show')" />
            <app-edit-button @click="showProductDetails(item, 'edit')" />
            <app-delete-button @click="showModalConfirmDelete(item, 'delete')" />
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

  <ShowProductDetails
    v-model="showModalProductDetails"
    :selected-product="selectedProduct"
    :show-confirm-button="false"
    cancel-text="Cerrar"
    @close="showModalProductDetails = false"
  />

  <ConfirmDeleteProduct
    v-model="showModalDeleteProduct"
    cancel-text="Cancelar"
    confirm-text="Confirmar"
    @close="showModalDeleteProduct = false"
    @confirm="confirmDelete(selectedProduct)"
  />

  <EditProduct
    v-if="showModalEditProduct"
    v-model="showModalEditProduct"
    :selected-product="selectedProduct"
    cancel-text="Cancelar"
    confirm-text="Guardar"
    @close="showModalEditProduct = false"
    @confirm-edit="editarProducto"
  />

  <CreateProduct
    v-if="showModalCreateProduct"
    v-model="showModalCreateProduct"
    :selected-product="selectedProduct"
    cancel-text="Cancelar"
    confirm-text="Crear"
    @close="showModalCreateProduct = false"
    @confirm-create="crearProducto"
  />
</template>

<script setup>
import productsService from '@/services/products/products.service'
import ShowProductDetails from '../components/ShowProductDetails.vue'
import ConfirmDeleteProduct from '../components/ConfirmDeleteProduct.vue'
import EditProduct from '../components/EditProduct.vue'
import CreateProduct from '../components/CreateProduct.vue'
import { useAppStore } from '@/stores/app.store'

const { showLoader, hideLoader } = useAppStore()
const alertToast = inject('alertToast')

const title = 'Gestión de productos'
const breadcrumbs = [
  {
    title: 'Productos',
    disable: true,
    href: '#'
  }
]
const headers = [
  { title: 'ID', value: 'id' },
  { title: 'Nombre', value: 'nombre' },
  { title: 'Descripción', value: 'descripcion' },
  { title: 'Precio actual ($)', value: 'precio_actual' },
  { title: 'Stock actual', value: 'stock_actual' },
  { title: 'Estado', value: 'estado' },
  { title: 'Acciones', value: 'actions', sortable: false, align: 'center' }
]
const products = ref([])
const selectedProduct = ref(null)
const actionItem = ref(null)
const loading = ref(false)
const totalPages = ref(0)
const page = ref(1)
const itemsPerPage = ref(10)

const showModalProductDetails = ref(false)
const showModalCreateProduct = ref(false)
const showModalEditProduct = ref(false)
const showModalDeleteProduct = ref(false)

const getProducts = async () => {
  loading.value = true
  try {
    const filters = {
      page: page.value,
      per_page: itemsPerPage.value
    }
    const { data, error } = await productsService.list(filters)
    if (error) {
      alertToast({
        text: error,
        type: 'error'
      })
      return
    }
    products.value = data.data
    totalPages.value = data.pagination.totalPages
    page.value = data.pagination.page
  } catch (_error) {
    alertToast({
      text: 'Error al cargar los productos',
      type: 'error'
    })
  } finally {
    loading.value = false
  }
}

const showProductDetails = async (item, action) => {
  showLoader()
  actionItem.value = action
  try {
    const { id } = item
    const { data, error } = await productsService.details(id)
    if (error) {
      alertToast({
        text: error,
        type: 'error'
      })
      return
    }
    selectedProduct.value = data.data
    if (action === 'edit') {
      showModalEditProduct.value = true
    } else if (action === 'delete') {
      showModalDeleteProduct.value = true
    } else {
      showModalProductDetails.value = true
    }
  } catch (_error) {
    alertToast({
      text: 'Error al cargar el producto',
      type: 'error'
    })
  } finally {
    hideLoader()
  }
}

const showModalConfirmDelete = async (item) => {
  actionItem.value = 'delete'
  selectedProduct.value = item
  showModalDeleteProduct.value = true
}

const confirmDelete = async (item) => {
  showLoader()
  try {
    const { id } = item
    const { error } = await productsService.destroy(id)
    if (error) {
      alertToast({
        text: error,
        type: 'error'
      })
      return
    }
    alertToast({
      text: 'Producto eliminado correctamente',
      type: 'success'
    })
    showModalDeleteProduct.value = false
    getProducts()
  } catch (_error) {
    alertToast({
      text: 'Error al eliminar el producto',
      type: 'error'
    })
  } finally {
    hideLoader()
  }
}

const editarProducto = async (item) => {
  showLoader()
  try {
    const { id } = item
    const dataItem = Object.keys(item).reduce((acc, key) => {
      if (item[key]) {
        acc[key] = item[key]
      }
      return acc
    }, {})
    const { error } = await productsService.edit(id, dataItem)
    if (error) {
      alertToast({
        text: error,
        type: 'error'
      })
      return
    }
    alertToast({
      text: 'Producto editado correctamente',
      type: 'success'
    })
    showModalEditProduct.value = false
    getProducts()
  } catch (_error) {
    alertToast({
      text: 'Error al editar el producto',
      type: 'error'
    })
  } finally {
    hideLoader()
  }
}

const crearProducto = async (item) => {
  showLoader()
  try {
    const dataItem = Object.keys(item).reduce((acc, key) => {
      if (item[key]) {
        acc[key] = item[key]
      }
      return acc
    }, {})
    const { error } = await productsService.create(dataItem)
    if (error) {
      alertToast({
        text: error,
        type: 'error'
      })
      return
    }
    alertToast({
      text: 'Producto creado correctamente',
      type: 'success'
    })
    showModalCreateProduct.value = false
    getProducts()
  } catch (_error) {
    alertToast({
      text: 'Error al crear el producto',
      type: 'error'
    })
  } finally {
    hideLoader()
  }
}

const createProduct = () => {
  selectedProduct.value = null
  showModalCreateProduct.value = true
}

watch(page, () => {
  getProducts();
});

await getProducts()
</script>
