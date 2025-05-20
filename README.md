# Inventory Library App

Aplicación para gestionar el inventario de una librería.

![image](https://github.com/user-attachments/assets/5c5a2e25-8f09-448f-bbdf-48e7db590c66)

La aplicación base permite:

1. Gestionar productos

![image](https://github.com/user-attachments/assets/f47eba52-9e6a-4fd5-8165-5ae112c73a46)

3. Gestión de categorías

![image](https://github.com/user-attachments/assets/38e0d910-bb99-4d45-b236-c15cf78e90ed)

5. Movimientos de inventario

![image](https://github.com/user-attachments/assets/0cab8915-b707-44b8-9b4f-b69256ad1ecc)


## Tecnologías
- **Vue 3**: Framework de JavaScript para construir interfaces de usuario.
- **Vuetify 3**: Framework de componentes de Material Design para Vue.js.
- **Laravel 11**: Framework de PHP para construir aplicaciones web.
- **MySQL**: Sistema de gestión de bases de datos relacional.

## Instalación (manual)

1. Clona el repositorio:
```bash
git clone https://github.com/daiv05/inventory-library-app.git
cd inventory-library-app
```
### Frontend
2. Navega al directorio del frontend:
```bash
cd frontend
```
3. Instala las dependencias:
```bash
npm install
```
4. Copia el archivo `.env.example` a `.env` y ajusta las variables de entorno según tus necesidades:
```bash
cp .env.example .env
```
5. Inicia el servidor de desarrollo:
```bash
npm run dev
```

> [!IMPORTANT]
> El puerto configurado para el frontend es `3090`

### Backend
6. Navega al directorio del backend:
```bash
cd backend
```
7. Instala las dependencias:
```bash
composer install
```
8. Copia el archivo `.env.example` a `.env` y ajusta las variables de entorno según tus necesidades:
```bash
cp .env.example .env
```
9. Genera la clave de la aplicación:
```bash
php artisan key:generate
```
10. Genera la jwt secret:
```bash
php artisan jwt:secret
```
11. Ejecuta las migraciones:
```bash
php artisan migrate --seed
```
12. Inicia el servidor de desarrollo:
```bash
php artisan serve --port 9090
```

> [!IMPORTANT]
> El puerto configurado para el backend es `9090`


## Instalación (docker)

El proyecto incluye un archivo `docker-compose.yml` para facilitar la instalación y ejecución de la aplicación en contenedores Docker.
### Requisitos previos
- Docker y Docker Compose instalados en tu máquina.
### Pasos para la instalación
1. Clona el repositorio:
```bash
git clone https://github.com/daiv05/inventory-library-app.git
cd inventory-library-app
```
2. Antes de continuar, es necesario configurar los archivos `.env` para el frontend y el backend, ademas del archivo `.env` que utiliza docker-compose. Para ello, copia los archivos de ejemplo y edita según tus necesidades:
```bash
cp frontend/.env.example frontend/.env
cp backend/.env.example backend/.env
cp .env.example .env
```

En el archivo `.env` de docker-compose se configura las credenciales de acceso a la base de datos y una bdd inicial, el resto de variables de entorno se configuran en los archivos `.env` del frontend y backend.

> [!IMPORTANT]
> Asegurarse de que el nombre de la base de datos del `.env` de docker-compose coincida con el utilizado en el `.env` del backend, asi como el nombre de usuario y contraseña
> Asi mismo, el valor del `DB_HOST` en el archivo `.env` del backend debe ser `mysql` (NO usar localhost), que es el nombre del servicio de la base de datos en el archivo `docker-compose.yml`.

```dotenv

3. Construye y levanta los contenedores:
```bash
docker-compose up -d --build
```
4. Ejecutaremos los siguientes comandos para terminar de configurar el backend:
```bash
docker-compose exec backend php artisan jwt:secret --force
docker-compose exec backend php artisan migrate --seed
docker-compose exec backend php artisan storage:link
```
5. Ahora si podemos acceder a la aplicación:
   - Frontend: `http://localhost:3090`
   - Backend: `http://localhost:9090`

> [!CAUTION]
> La aplicación se ejecuta en modo de desarrollo, los cambios en el código fuente se reflejarán automáticamente en los contenedores.

Copyright (c) 2025-presente David Deras
