import httpClient from '@/http-clients/index'
import HttpRequestMethods from '@/utils/http/const/HttpRequestMethods'

const API_URL = `${import.meta.env.VITE_VUE_APP_API_URL}/api`

const list = async (filters) =>
  await httpClient(HttpRequestMethods.GET, `${API_URL}/catalogos/estados`, filters)

export default {
  list
}