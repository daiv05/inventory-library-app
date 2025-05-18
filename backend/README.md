# Bsckend
Aplicación backend desarrollada con Laravel 11, MySQL y JWT Auth.

## Estructura de carpetas

```bash
backend
├── app
│   ├── Enums
│   ├── Http
│       ├── Controllers
│       ├── Middleware
│   ├── Models
│       ├── Catalogo
│       ├── Inventario
│       ├── Productos
│       ├── Registro
│       ├── Seguridad
│   ├── Traits
│       ├── PaginationTrait.php
│       ├── ResponseTrait.php
├── bootstrap
├── config
├── database
│   ├── factories
│   ├── migrations
│   ├── seeders
├── public
├── routes
│   ├── api.php
│   ├── public.php
```

## Estructura de controladores y modelos

Para llevar un mejor control de los controladores y modelos, se ha creado una carpeta por cada uno de los módulos de la aplicación.

## Traits
Se han creado traits para la paginación y la respuesta de las peticiones con el fin de evitar la duplicación de código y estandarizar la respuesta de la API.

```php
use App\Traits\PaginationTrait;
use App\Traits\ResponseTrait;

class InventarioController extends Controller
{
    use PaginationTrait, ResponseTrait;

    public function index(Request $request)
    {
        $inventario = Inventario::all()
        $paginatedData = $this->paginate($inventario->toArray(), request('per_page', GeneralEnum::PAGINACION->value), request('page', 1));
        return $this->successPaginated('Inventario obtenido exitosamente', $paginatedData, Response::HTTP_OK);
    }
}
```

Copyright (c) 2025-presente David Deras
