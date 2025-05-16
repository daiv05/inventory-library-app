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

  const { setLoading } = useAppStore()

  async function login(email, password) {
    try {
      setLoading(true)
      const { data, error } = await authSevices.loginUser({ email, password })
      console.log(data, error)
      if (error) {
        setLoading(false)
        notification.alertToast({
          title: 'Error!',
          message: error,
          type: 'error'
        })
        return
      }
      setAuthData(data.accessToken)
      setLoading(false)
      notification.alertToast({
        title: 'Bienvenido!',
        message: 'Inicio de sesión exitoso',
        type: 'success'
      })
      router.push({ name: 'inicio' })
    } catch (error) {
      console.error(error)
      setLoading(false)
      notification.alertToast({
        title: 'Error!',
        message: error,
        type: 'error'
      })
    }
  }

  async function logout() {
    try {
      setLoading(true)
      const { error } = await authSevices.logoutUser()
      if (error) {
        setLoading(false)
        notification.alertToast({
          title: 'Error!',
          message: error,
          type: 'error'
        })
        return
      }
      resetAuthData()
      setLoading(false)
      notification.alertToast({
        title: 'Adiós!',
        message: 'Sesión cerrada exitosamente',
        type: 'success'
      })
    } catch (error) {
      setLoading(false)
      notification.alertToast({
        title: 'Error!',
        message: error,
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

  return { user, token, login, logout, setAuthData }
})
