<template>
  <v-footer class="footer d-flex flex-column justify-center text-center align-center">
    <div class="my-2"></div>
    <div class="text-center mb-2">
      <span class="text-grey-darken-1"
        >&copy; {{ formatCurrentDate('YYYY') }} DV Library. Todos los derechos reservados.</span
      >
    </div>
  </v-footer>
</template>

<script setup>
import { formatCurrentDate } from '@/utils/dates/formatting'
</script>

<style scoped>
.footer {
  text-align: center;
  font-size: 10px;
  color: #000000;
}

.icon-footer {
  width: 20px;
  height: 20px;
}
</style>
