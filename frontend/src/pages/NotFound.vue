<template>
  <v-container>
    <v-row class="h-100 d-flex align-center">
      <v-col cols="12">
        <v-card elevation="1" rounded="md" class="mx-auto">
          <v-card-title class="text-center my-8" theme="DVThemeLigth">
            <h3 class="text-h1">404 Not Found</h3>
            <icon-mdi-image-broken class="gradient-svg" style="font-size: 200px" />
          </v-card-title>
          <v-card-text class="d-flex flex-column justify-center text-center">
            <p class="text-subtitle-1 font-weight-bold">LA PÁGINA QUE ESTÁS BUSCANDO NO EXISTE</p>
            <p class="text-subtitle-2">
              ES POSIBLE QUE LA PÁGINA HAYA SIDO ELIMINADA O QUE EL ENLACE ESTÉ ROTO
            </p>
            <p class="text-subtitle-2">
              <router-link :to="{ name: 'inicio' }" class="text-primary"
                >Volver al inicio</router-link
              >
            </p>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
