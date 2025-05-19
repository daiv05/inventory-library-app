# Frontend

Aplicación frontend desarrollada con Vue 3 y Vuetify 3.

## Estructura de carpetas

```bash
frontend
├── public
│   ├── favicon.ico
│   ├── library.png
├── src
│   ├── assets
│   ├── components
│   ├── directives
│   ├── http-clients
│       ├── axios-client.js
│   ├── layouts
│   ├── navigation
│   ├── pages
│       ├── auth
│       ├── products
│       ├── inventory
│   ├── plugins
│       ├── axios.js
│       ├── notification.js
│       ├── vuetify.js
│   ├── router
│   ├── services
│   ├── store
│   ├── styles
│   ├── themes
│   ├── utils
│   ├── App.vue
│   ├── main.js
```

## Eslint y Prettier

El proyecto utiliza Eslint y Prettier para el formateo de código.

```bash
npm run format # Formatear
npm run lint # Verificar
```

## Cliente http

El cliente http se encuentra en `src/http-clients/axios-client.js`.
Se utiliza para realizar peticiones a la API.

```javascript
const loginUser = async (data) =>
  await httpClient(HttpRequestMethods.POST, `${PUBLIC_URL}/auth/login`, {}, data)

const { data, error, status } = await loginUser({ email, password })
```

Copyright (c) 2025-presente David Deras
