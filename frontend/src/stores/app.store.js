// Utilities
import { useLocalStorage } from '@vueuse/core'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAppStore = defineStore('app', () => {
  const isLoading = ref(0)
  const drawer = ref(true)
  const miniSidebar = ref(false)
  const darkMode = useLocalStorage('darkMode', false)

  function showLoader() {
    isLoading.value++
  }

  function hideLoader() {
    isLoading.value--
  }

  function toggleDrawer() {
    drawer.value = !drawer.value
  }

  function toggleMiniSidebar() {
    miniSidebar.value = !miniSidebar.value
  }

  return {
    isLoading,
    showLoader,
    hideLoader,
    drawer,
    toggleDrawer,
    miniSidebar,
    toggleMiniSidebar,
    darkMode
  }
})
