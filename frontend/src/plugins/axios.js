import axios from 'axios'
import { useAuthStore } from '@/stores/auth.store.js'
import router from '../router'
import notification from './notification'

const _axios = axios.create({
  baseURL: import.meta.env.VITE_BASE_API_URL,
  timeout: 10000
})

_axios.interceptors.request.use(
  function (config) {
    const { token } = useAuthStore()

    if (token) config.headers.Authorization = 'Bearer ' + token

    return config
  },
  function (error) {
    return Promise.reject(error)
  }
)

_axios.interceptors.response.use(
  (response) => response,
  async (error) => {
    const { token, setAuthData, resetAuthData } = useAuthStore()
    const { response, request, _message } = error
    let alertErrorText = ':('
    if (response) {
      if (response.status >= 500) {
        alertErrorText =
          response.data.message || 'Error en el servidor, por favor intenta más tarde'
      }
      if (response.status === 422) {
        alertErrorText =
          response.data.message || 'Error en la petición, por favor revisa los datos ingresados'
      }
      if (response.status === 400) {
        alertErrorText = response.data.message || 'Error en la petición, por favor revisa los datos'
      }
      if (response.status === 401) {
        if (router.currentRoute.value.name !== 'login') {
          try {
            const responseRefresh = await axios.post(
              `${import.meta.env.VITE_VUE_APP_API_URL}/api/auth/refresh`,
              {},
              {
                headers: {
                  Authorization: 'Bearer ' + token
                }
              }
            )
            if (response.status === 200) {
              const newToken = responseRefresh.data.data.accessToken
              setAuthData(newToken)
              response.config.headers['Authorization'] = 'Bearer ' + newToken
              return _axios(response.config)
            }
          } catch (_error) {
            resetAuthData()
            alertErrorText = 'Sesión expirada, por favor inicie sesión nuevamente'
          }
        } else {
          alertErrorText =
            response.data.message ||
            'Ocurrió un error al intentar iniciar sesión, por favor intenta nuevamente'
        }
      }
      if (response.status === 403) {
        router.push('/')
        alertErrorText = response.data.message || 'No tienes permisos para realizar esta acción'
      }
    } else if (request) {
      alertErrorText = 'No se pudo conectar al servidor, por favor intenta más tarde'
    } else {
      alertErrorText = 'Ocurrió un error inesperado, por favor intenta más tarde'
    }

    notification.alertToast({
      type: 'error',
      text: alertErrorText
    })

    return Promise.reject(error)
  }
)

export default _axios
