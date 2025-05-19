import _axios from '@/plugins/axios'

export default async function axiosClient(config) {
  const configAxios = {
    method: config.method,
    url: config.url,
    headers: config.headers,
    responseType: config.responseType,
    baseURL: config.baseURL,
    params: config.params,
    data: config.data
  }

  let response = null
  let error = null
  let status = null

  await _axios(configAxios)
    .then((res) => {
      response = res.data
      status = res.status
      return res
    })
    .catch((err) => {
      if (err.response) {
        error = err.response.data.message || 'Ocurrió un error inesperado'
      } else if (err.request) {
        error = err.request || 'No se pudo conectar al servidor, por favor intenta más tarde'
      } else {
        error = err.message || 'Ocurrió un error inesperado'
      }
    })

  return {
    data: response,
    error: error,
    status: status
  }
}
