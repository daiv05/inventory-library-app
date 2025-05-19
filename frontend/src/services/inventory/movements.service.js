import httpClient from '@/http-clients/index'
import HttpRequestMethods from '@/utils/http/const/HttpRequestMethods'

const API_URL = `${import.meta.env.VITE_VUE_APP_API_URL}/api`

const list = async (filters) =>
  await httpClient(HttpRequestMethods.GET, `${API_URL}/inventario/kardex`, filters)

const details = async (id) =>
  await httpClient(HttpRequestMethods.GET, `${API_URL}/inventario/kardex/${id}`)

const create = async (data) =>
  await httpClient(HttpRequestMethods.POST, `${API_URL}/inventario/registrar-movimiento`, {}, data)

export default {
  list,
  details,
  create
}