<template>
  <AppBreadcrumb :title="title" :breadcrumbs="breadcrumbs"></AppBreadcrumb>
  <v-row>
    <v-col cols="12">
      <AppBaseCard title="Listado">
        <v-row class="mb-4">
          <v-col cols="12" class="d-flex justify-end">
            <v-btn class="text-none" elevation="0" color="secondary" @click="createCategory()">
              Crear categoría
            </v-btn>
          </v-col>
        </v-row>
        <AppDataTable :headers="headers" :items="categories" :loading="loading">
          <template #item.estado="{ item }">
            <app-status-chip :status="item.id_estado" />
          </template>
          <template #item.actions="{ item }">
            <app-show-button @click="showCategoryDetails(item, 'show')" />
            <app-edit-button @click="showCategoryDetails(item, 'edit')" />
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

  <ShowCategoryDetails
    v-model="showModalCategoryDetails"
    :selected-category="selectedCategory"
    :show-confirm-button="false"
    cancel-text="Cerrar"
    @close="showModalCategoryDetails = false"
  />

  <ConfirmDeleteCategory
    v-model="showModalDeleteCategory"
    cancel-text="Cancelar"
    confirm-text="Confirmar"
    @close="showModalDeleteCategory = false"
    @confirm="confirmDelete(selectedCategory)"
  />

  <EditCategory
    v-if="showModalEditCategory"
    v-model="showModalEditCategory"
    :selected-category="selectedCategory"
    cancel-text="Cancelar"
    confirm-text="Guardar"
    @close="showModalEditCategory = false"
    @confirm-edit="editarCategoria"
  />

  <CreateCategory
    v-if="showModalCreateCategory"
    v-model="showModalCreateCategory"
    :selected-category="selectedCategory"
    cancel-text="Cancelar"
    confirm-text="Crear"
    @close="showModalCreateCategory = false"
    @confirm-create="crearCategoria"
  />
</template>

<script setup>
import { ref } from 'vue'
import categoriesServices from '@/services/products/categorias.service'
import ShowCategoryDetails from '../components/ShowCategoryDetails.vue'
import ConfirmDeleteCategory from '../components/ConfirmDeleteCategory.vue'
import EditCategory from '../components/EditCategory.vue'
import CreateCategory from '../components/CreateCategory.vue'
import { useAppStore } from '@/stores/app.store'

const { showLoader, hideLoader } = useAppStore()
const alertToast = inject('alertToast')

const title = 'Gestión de categorias'
const breadcrumbs = [
  {
    title: 'Categorias',
    disable: true,
    href: '#'
  }
]
const headers = [
  { title: 'ID', value: 'id' },
  { title: 'Nombre', value: 'nombre' },
  { title: 'Descripción', value: 'descripcion' },
  { title: 'Estado', value: 'estado' },
  { title: 'Acciones', value: 'actions', sortable: false, align: 'center' }
]
const categories = ref([])
const selectedCategory = ref(null)
const actionItem = ref(null)
const loading = ref(false)
const totalPages = ref(0)
const page = ref(1)
const itemsPerPage = ref(10)

const showModalCategoryDetails = ref(false)
const showModalCreateCategory = ref(false)
const showModalEditCategory = ref(false)
const showModalDeleteCategory = ref(false)

const getCategories = async () => {
  loading.value = true
  try {
    const filters = {
      page: page.value,
      per_page: itemsPerPage.value
    }
    const { data, error } = await categoriesServices.listData(filters)
    if (error) {
      return
    }
    categories.value = data.data
    totalPages.value = data.pagination.totalPages
    page.value = data.pagination.page
  } catch (error) {
    alertToast({
      text: 'Error al cargar las categorias',
      type: 'error'
    })
    throw error
  } finally {
    loading.value = false
  }
}

const showCategoryDetails = async (item, action) => {
  showLoader()
  actionItem.value = action
  try {
    const { id } = item
    const { data, error } = await categoriesServices.details(id)
    if (error) {
      return
    }
    selectedCategory.value = data.data
    if (action === 'edit') {
      showModalEditCategory.value = true
    } else if (action === 'delete') {
      showModalDeleteCategory.value = true
    } else {
      showModalCategoryDetails.value = true
    }
  } catch (error) {
    alertToast({
      text: 'Error al cargar la categoría',
      type: 'error'
    })
    throw error
  } finally {
    hideLoader()
  }
}

const showModalConfirmDelete = async (item) => {
  actionItem.value = 'delete'
  selectedCategory.value = item
  showModalDeleteCategory.value = true
}

const confirmDelete = async (item) => {
  showLoader()
  try {
    const { id } = item
    const { error } = await categoriesServices.destroy(id)
    if (error) {
      return
    }
    alertToast({
      text: 'Categoría eliminado correctamente',
      type: 'success'
    })
    showModalDeleteCategory.value = false
    getCategories()
  } catch (error) {
    alertToast({
      text: 'Error al eliminar el categoría',
      type: 'error'
    })
    throw error
  } finally {
    hideLoader()
  }
}

const editarCategoria = async (item) => {
  showLoader()
  try {
    const { id } = item
    const dataItem = Object.keys(item).reduce((acc, key) => {
      if (item[key]) {
        acc[key] = item[key]
      }
      return acc
    }, {})
    const { error } = await categoriesServices.edit(id, dataItem)
    if (error) {
      return
    }
    alertToast({
      text: 'Categoría editada correctamente',
      type: 'success'
    })
    showModalEditCategory.value = false
    await getCategories()
  } catch (error) {
    alertToast({
      text: 'Error al editar la categoría',
      type: 'error'
    })
    throw error
  } finally {
    hideLoader()
  }
}

const crearCategoria = async (item) => {
  showLoader()
  try {
    const dataItem = Object.keys(item).reduce((acc, key) => {
      if (item[key]) {
        acc[key] = item[key]
      }
      return acc
    }, {})
    const { error } = await categoriesServices.create(dataItem)
    if (error) {
      return
    }
    alertToast({
      text: 'Categoria creado correctamente',
      type: 'success'
    })
    showModalCreateCategory.value = false
    getCategories()
  } catch (error) {
    alertToast({
      text: 'Error al crear la categoría',
      type: 'error'
    })
    throw error
  } finally {
    hideLoader()
  }
}

const createCategory = () => {
  selectedCategory.value = null
  showModalCreateCategory.value = true
}

watch(page, () => {
  getCategories()
})

await getCategories()
</script>
