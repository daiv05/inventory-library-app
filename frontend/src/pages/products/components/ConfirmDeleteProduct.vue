<template>
  <app-modal :max-width="'500px'" :danger-button="true">
    <template #body>
      <v-row dense>
        <v-col cols="12">
          <v-list-item class="d-flex justify-center">
            <span class="text-h5 text-lightText font-weight-bold"
              >¿Está seguro de que desea eliminar este producto?</span
            >
          </v-list-item>
        </v-col>
        <v-col cols="12">
          <v-list class="pt-0">
            <v-list-item class="d-flex justify-center">
              <div>
                <v-list-item-title
                  class="text-lightText text-center"
                  style="white-space: normal; text-overflow: unset; overflow: visible"
                >
                  Esta acción es irreversible, el producto se eliminará de forma permanente.
                </v-list-item-title>
              </div>
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
