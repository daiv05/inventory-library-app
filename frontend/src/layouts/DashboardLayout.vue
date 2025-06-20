<template>
  <v-app class="bg-surface" :class="[miniSidebar ? 'mini-sidebar' : '']">
    <TheAppDrawer style="position: fixed" />
    <TheAppBar />
    <v-main style="--v-layout-top: 0px">
      <v-container fluid class="page-wrapper">
        <RouterView v-slot="{ Component }">
          <template v-if="Component">
            <Transition name="slide-fade" mode="out-in">
              <KeepAlive>
                <div>
                  <the-app-error-card
                    v-if="errorCaptured.length > 0"
                    :error-captured="errorCaptured"
                  />
                  <Suspense v-else timeout="0">
                    <!-- main content -->
                    <component :is="Component"></component>
                    <!-- loading state -->
                    <template #fallback>
                      <AppLoader />
                    </template>
                  </Suspense>
                </div>
              </KeepAlive>
            </Transition>
          </template>
        </RouterView>
      </v-container>
      <TheAppFooter />
    </v-main>
  </v-app>
</template>

<script setup>
import { useAppStore } from '@/stores/app.store'
import { useAuthStore } from '@/stores/auth.store'
import { storeToRefs } from 'pinia'
import { onErrorCaptured } from 'vue'
import router from '@/router'
import notification from '@/plugins/notification'
const { miniSidebar } = storeToRefs(useAppStore())
const { isAuthenticated } = storeToRefs(useAuthStore())

const errorCaptured = ref([])
onErrorCaptured((error) => {
  errorCaptured.value.push({
    error
  })
  return true
})

watch(isAuthenticated, async (newValue) => {
  if (!newValue) {
    notification.alertToast({
      title: 'Sesión terminada',
      text: 'Por favor inicie sesión nuevamente',
      type: 'error'
    })
    await router.push({
      name: 'login'
    })
  }
})
</script>

<style scoped lang="scss">
.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: opacity 0.1s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  opacity: 0;
}

:deep(.v-card-actions) {
  min-height: 0;
  display: flex;
  justify-content: center;
}
</style>
