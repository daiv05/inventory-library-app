import httpClient from '@/http-clients/index'
import HttpRequestMethods from '@/utils/http/const/HttpRequestMethods'

const API_URL = `${import.meta.env.VITE_VUE_APP_API_URL}/api`

const list = async () =>
  await httpClient(HttpRequestMethods.GET, `${API_URL}/catalogos/tipos-movimientos`)

export default {
  list
}
