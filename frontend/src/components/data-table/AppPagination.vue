<template>
  <v-row class="d-flex justify-center mt-4">
    <v-col cols="12">
      <v-pagination
        v-model="page"
        :length="totalPages"
        :total-visible="mobile ? 3 : 5"
        color="lightText"
        density="compact"
      ></v-pagination>
    </v-col>
  </v-row>
</template>
<script setup lang="ts">
import { ref, watch } from 'vue'
import { useDisplay } from 'vuetify'

const { mobile } = useDisplay()

const props = defineProps({
  page: { type: Number, default: 1 },
  itemsPerPage: { type: Number, default: 10 },
  totalPages: { type: Number, required: true },
  position: { type: String, default: 'center' }
})

const page = ref(props.page)
const itemsPerPage = ref(props.itemsPerPage)

const emit = defineEmits(['update:page', 'update:itemsPerPage'])

watch(
  () => props.page,
  (newVal) => {
    page.value = newVal
  }
)

watch(
  () => props.itemsPerPage,
  (newVal) => {
    itemsPerPage.value = newVal
  }
)

watch(page, (newVal) => {
  emit('update:page', newVal)
})
</script>
