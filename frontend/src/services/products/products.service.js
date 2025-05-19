import httpClient from '@/http-clients/index'
import HttpRequestMethods from '@/utils/http/const/HttpRequestMethods'

const API_URL = `${import.meta.env.VITE_VUE_APP_API_URL}/api`

const list = async (filters) =>
  await httpClient(HttpRequestMethods.GET, `${API_URL}/inventario/productos`, filters)

const details = async (id) =>
  await httpClient(HttpRequestMethods.GET, `${API_URL}/inventario/productos/${id}`)

const create = async (data) =>
  await httpClient(HttpRequestMethods.POST, `${API_URL}/inventario/productos`, {}, data)

const edit = async (id, data) =>
  await httpClient(HttpRequestMethods.PUT, `${API_URL}/inventario/productos/${id}`, {}, data)

const destroy = async (id) =>
  await httpClient(HttpRequestMethods.DELETE, `${API_URL}/inventario/productos/${id}`)

const search = async (search) =>
  await httpClient(HttpRequestMethods.GET, `${API_URL}/inventario/productos/kardex/search`, search)

export default {
  list,
  details,
  create,
  edit,
  destroy,
  search
}
