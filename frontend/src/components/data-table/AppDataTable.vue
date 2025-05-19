<template>
  <v-data-table
    :headers="headers"
    :items="items"
    class="elevation-0"
    :loading="loading"
    hide-default-footer
    no-data-text="No hay datos disponibles"
    color="primary"
  >
    <template #loading>
      <v-skeleton-loader type="table-row@10"></v-skeleton-loader>
    </template>
    <template v-for="(name) in Object.keys($slots)" #[name]="data">
      <slot :name="name" v-bind="data"></slot>
    </template>
  </v-data-table>
</template>

<script setup>
defineProps({
  headers: {
    type: Array,
    required: true
  },
  items: {
    type: Array,
    required: true
  },
  loading: {
    type: Boolean,
    default: false
  }
})
</script>

<style>
::v-deep .v-data-table-header {
  background-color: #DCDCDC;
}
</style>