import { defineStore } from 'pinia'
import router from '../router'
import { useStorage } from '@vueuse/core'
import notification from '@/plugins/notification'
import { jwtDecode } from 'jwt-decode'
import { useAppStore } from '@/stores/app.store'
import authSevices from '@/services/auth.sevices'

export const useAuthStore = defineStore('auth', () => {
  const user = useStorage('user', {
    id: null,
    username: null,
    email: null,
    role: null
  })
  const token = useStorage('token', null)

  const isAuthenticated = computed(() => !!token.value)

  const { showLoader, hideLoader } = useAppStore()

  async function login(email, password) {
    try {
      showLoader()
      const { data, error } = await authSevices.loginUser({ email, password })
      if (error) {
        hideLoader()
        return
      }
      if (!data.data.accessToken) {
        hideLoader()
        notification.alertToast({
          title: 'Error!',
          text: 'No se ha podido iniciar sesión',
          type: 'error'
        })
        return
      }
      setAuthData(data.data.accessToken)
      hideLoader()
      notification.alertToast({
        title: 'Bienvenido!',
        text: 'Inicio de sesión exitoso',
        type: 'success'
      })
      await router.push({ name: 'inicio' })
    } catch (error) {
      console.error(error)
      hideLoader()
      notification.alertToast({
        title: 'Error!',
        text: error,
        type: 'error'
      })
    }
  }

  async function logout() {
    try {
      showLoader()
      const { error } = await authSevices.logoutUser()
      if (error) {
        hideLoader()
        return
      }
      resetAuthData()
      hideLoader()
      notification.alertToast({
        text: 'Sesión cerrada exitosamente',
        type: 'success'
      })
    } catch (error) {
      hideLoader()
      notification.alertToast({
        title: 'Error!',
        text: error,
        type: 'error'
      })
    }
  }

  function setAuthData(jwtToken) {
    const decodedToken = jwtDecode(jwtToken)
    token.value = jwtToken
    user.value = {
      id: decodedToken.id,
      username: decodedToken.username,
      email: decodedToken.email,
      role: decodedToken.role
    }
  }

  function resetAuthData() {
    user.value = {
      id: null,
      username: null,
      email: null,
      role: null
    }
    token.value = null
    router.push({ name: 'login' })
  }

  return { user, token, login, logout, setAuthData, isAuthenticated, resetAuthData }
})
