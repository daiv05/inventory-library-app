import httpClient from '@/http-clients/index'
import HttpRequestMethods from '@/utils/http/const/HttpRequestMethods'

const API_URL = `${import.meta.env.VITE_VUE_APP_API_URL}/api`

const list = async (filters) =>
  await httpClient(HttpRequestMethods.GET, `${API_URL}/inventario/categorias`, filters)

const listData = async (filters) =>
  await httpClient(HttpRequestMethods.GET, `${API_URL}/inventario/categorias`, filters)

const details = async (id) =>
  await httpClient(HttpRequestMethods.GET, `${API_URL}/inventario/categorias/${id}`)

const create = async (data) =>
  await httpClient(HttpRequestMethods.POST, `${API_URL}/inventario/categorias`, {}, data)

const edit = async (id, data) =>
  await httpClient(HttpRequestMethods.PUT, `${API_URL}/inventario/categorias/${id}`, {}, data)

const destroy = async (id) =>
  await httpClient(HttpRequestMethods.DELETE, `${API_URL}/inventario/categorias/${id}`)


export default {
  list,
  listData,
  details,
  create,
  edit,
  destroy
}