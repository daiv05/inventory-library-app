import httpClient from '@/http-clients/index'
import HttpRequestMethods from '@/utils/http/const/HttpRequestMethods'

const API_URL = `${import.meta.env.VITE_VUE_APP_API_URL}/api`
const PUBLIC_URL = `${import.meta.env.VITE_VUE_APP_API_URL}/public`

const loginUser = async (data) =>
  await httpClient(HttpRequestMethods.POST, `${PUBLIC_URL}/auth/login`, {}, data)

const logoutUser = async () => await httpClient(HttpRequestMethods.POST, `${API_URL}/auth/logout`)

export default {
  loginUser,
  logoutUser
}
