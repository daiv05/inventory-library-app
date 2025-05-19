<?php

namespace App\Http\Controllers\Productos;

use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use App\Models\Productos\DetalleProducto;
use App\Models\Productos\Producto;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\PaginationTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    use ResponseTrait, PaginationTrait;

    public function index(Request $request)
    {
        try {
            $productos = Producto::with(['categoria', 'estado', 'detalleProducto', 'detalleProducto.genero'])
                ->orderBy('created_at', 'desc')
                ->get();
            $paginatedData = $this->paginate($productos->toArray(), request('per_page', GeneralEnum::PAGINACION->value), $request['page'] ?? 1);
            return $this->successPaginated('Productos obtenidos exitosamente', $paginatedData, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error('Error al obtener los productos', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'id_categoria' => 'required|integer|exists:prd_categorias,id',
                'id_estado' => 'required|integer|exists:ctl_estados,id',
                'nombre' => 'required|string|max:50',
                'descripcion' => 'required|string|max:255',
                'codigo_producto' => 'required|string|max:50|unique:prd_detalles_productos,codigo_producto',
                'color' => 'string|max:50',
                'dimensiones' => 'string|max:50',
                'peso' => 'numeric',
                'material' => 'string|max:50',
                'autor' => 'string|max:50',
                'id_genero' => 'integer|exists:lib_generos,id',
                'isbn' => 'string|max:50',
                'anio_publicacion' => 'string|max:50',
            ], [
                'id_categoria.required' => 'El campo id_categoria es obligatorio.',
                'id_categoria.integer' => 'El campo id_categoria debe ser un número entero.',
                'id_categoria.exists' => 'No se encontró la categoría especificada.',
                'id_estado.required' => 'El campo id_estado es obligatorio.',
                'id_estado.integer' => 'El campo id_estado debe ser un número entero.',
                'id_estado.exists' => 'No se encontró el estado especificado.',
                'nombre.required' => 'El campo nombre es obligatorio.',
                'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
                'nombre.max' => 'El campo nombre no puede tener más de 50 caracteres.',
                'descripcion.required' => 'El campo descripcion es obligatorio.',
                'descripcion.string' => 'El campo descripcion debe ser una cadena de texto.',
                'descripcion.max' => 'El campo descripcion no puede tener más de 50 caracteres.',
                'codigo_producto.required' => 'El campo codigo_producto es obligatorio.',
                'codigo_producto.string' => 'El campo codigo_producto debe ser una cadena de texto.',
                'codigo_producto.max' => 'El campo codigo_producto no puede tener más de 50 caracteres.',
                'codigo_producto.unique' => 'El código de producto ya existe.',
                'color.string' => 'El campo color debe ser una cadena de texto.',
                'color.max' => 'El campo color no puede tener más de 50 caracteres.',
                'dimensiones.string' => 'El campo dimensiones debe ser una cadena de texto.',
                'dimensiones.max' => 'El campo dimensiones no puede tener más de 50 caracteres.',
                'peso.numeric' => 'El campo peso debe ser un número.',
                'material.string' => 'El campo material debe ser una cadena de texto.',
                'material.max' => 'El campo material no puede tener más de 50 caracteres.',
                'autor.string' => 'El campo autor debe ser una cadena de texto.',
                'id_genero.integer' => 'El campo id_genero debe ser un número entero.',
                'id_genero.exists' => 'No se encontró el género especificado.',
                'isbn.string' => 'El campo isbn debe ser una cadena de texto.',
                'isbn.max' => 'El campo isbn no puede tener más de 50 caracteres.',
                'anio_publicacion.string' => 'El campo anio_publicacion debe ser una cadena de texto.',
                'anio_publicacion.max' => 'El campo anio_publicacion no puede tener más de 50 caracteres.',
            ]);

            if ($validation->fails()) {
                return $this->validationError('Errores de validación', $validation->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $producto = Producto::create([
                'id_categoria' => $request->id_categoria,
                'id_estado' => $request->id_estado,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio_actual' => 0,
                'stock_actual' => 0,
            ]);
            $producto->detalleProducto()->create([
                'id_producto' => $producto->id,
                'autor' => $request->id_autor,
                'id_genero' => $request->id_genero,
                'codigo_producto' => $request->codigo_producto,
                'color' => $request->color,
                'dimensiones' => $request->dimensiones,
                'peso' => $request->peso,
                'material' => $request->material,
                'isbn' => $request->isbn,
                'anio_publicacion' => $request->anio_publicacion,
            ]);
            return $this->success('Producto creado exitosamente', $producto, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->error('Error al crear el producto', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $producto = Producto::findOrFail($id)->load(['categoria', 'estado', 'detalleProducto', 'detalleProducto.genero']);
            return $this->success('Producto encontrado', $producto, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error('Error al obtener el producto', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'id_categoria' => 'integer|exists:prd_categorias,id',
                'id_estado' => 'integer|exists:ctl_estados,id',
                'nombre' => 'string|max:50',
                'descripcion' => 'string|max:255',
                'codigo_producto' => 'string|max:50',
                'color' => 'string|max:50',
                'dimensiones' => 'string|max:50',
                'peso' => 'numeric',
                'material' => 'string|max:50',
                'autor' => 'string|max:50',
                'id_genero' => 'integer|exists:lib_generos,id',
                'isbn' => 'string|max:50',
                'anio_publicacion' => 'string|max:50',
            ], [
                'id_categoria.integer' => 'El campo id_categoria debe ser un número entero.',
                'id_categoria.exists' => 'No se encontró la categoría especificada.',
                'id_estado.integer' => 'El campo id_estado debe ser un número entero.',
                'id_estado.exists' => 'No se encontró el estado especificado.',
                'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
                'nombre.max' => 'El campo nombre no puede tener más de 50 caracteres.',
                'descripcion.string' => 'El campo descripcion debe ser una cadena de texto.',
                'descripcion.max' => 'El campo descripcion no puede tener más de 50 caracteres.',
                'codigo_producto.string' => 'El campo codigo_producto debe ser una cadena de texto.',
                'codigo_producto.max' => 'El campo codigo_producto no puede tener más de 50 caracteres.',
                'color.string' => 'El campo color debe ser una cadena de texto.',
                'color.max' => 'El campo color no puede tener más de 50 caracteres.',
                'dimensiones.string' => 'El campo dimensiones debe ser una cadena de texto.',
                'dimensiones.max' => 'El campo dimensiones no puede tener más de 50 caracteres.',
                'peso.numeric' => 'El campo peso debe ser un número.',
                'material.string' => 'El campo material debe ser una cadena de texto.',
                'material.max' => 'El campo material no puede tener más de 50 caracteres.',
                'id_autor.string' => 'El campo autor debe ser una cadena de texto.',
                'id_genero.integer' => 'El campo id_genero debe ser un número entero.',
                'id_genero.exists' => 'No se encontró el género especificado.',
                'isbn.string' => 'El campo isbn debe ser una cadena de texto.',
                'isbn.max' => 'El campo isbn no puede tener más de 50 caracteres.',
                'anio_publicacion.string' => 'El campo anio_publicacion debe ser una cadena de texto.',
                'anio_publicacion.max' => 'El campo anio_publicacion no puede tener más de 50 caracteres.',
            ]);
            if ($request->filled('codigo_producto')) {
                $validation->after(function ($validator) use ($request, $id) {
                    $producto = Producto::where('id', '!=', $id)->whereHas('detalleProducto', function ($query) use ($request) {
                        $query->where('codigo_producto', $request->codigo_producto);
                    })->first();
                    if ($producto) {
                        $validator->errors()->add('codigo_producto', 'El código de producto ya existe.');
                    }
                });
            }
            if ($request->filled('isbn')) {
                $validation->after(function ($validator) use ($request, $id) {
                    $producto = Producto::where('id', '!=', $id)->whereHas('detalleProducto', function ($query) use ($request) {
                        $query->where('isbn', $request->isbn);
                    })->first();
                    if ($producto) {
                        $validator->errors()->add('isbn', 'El ISBN ya existe.');
                    }
                });
            }

            if ($validation->fails()) {
                return $this->validationError('Errores de validación', $validation->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $producto = Producto::findOrFail($id);
            $detalleProducto = DetalleProducto::firstOrCreate(['id_producto' => $producto->id]);
            error_log(json_encode($detalleProducto));
            if ($request->filled('id_categoria')) {
                $producto->id_categoria = $request->id_categoria;
            }
            if ($request->filled('id_estado')) {
                $producto->id_estado = $request->id_estado;
            }
            if ($request->filled('nombre')) {
                $producto->nombre = $request->nombre;
            }
            if ($request->filled('descripcion')) {
                $producto->descripcion = $request->descripcion;
            }
            if ($request->filled('codigo_producto')) {
                $detalleProducto->codigo_producto = $request->codigo_producto;
            }
            if ($request->filled('color')) {
                $detalleProducto->color = $request->color;
            }
            if ($request->filled('dimensiones')) {
                $detalleProducto->dimensiones = $request->dimensiones;
            }
            if ($request->filled('peso')) {
                $detalleProducto->peso = $request->peso;
            }
            if ($request->filled('material')) {
                $detalleProducto->material = $request->material;
            }
            if ($request->filled('autor')) {
                $detalleProducto->autor = $request->autor;
            }
            if ($request->filled('id_genero')) {
                $detalleProducto->id_genero = $request->id_genero;
            }
            if ($request->filled('isbn')) {
                $detalleProducto->isbn = $request->isbn;
            }
            if ($request->filled('anio_publicacion')) {
                $detalleProducto->anio_publicacion = $request->anio_publicacion;
            }
            $producto->save();
            $detalleProducto->save();
            return $this->success('Producto actualizado exitosamente', $producto, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error('Error al actualizar el producto', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->delete();
            return $this->success('Producto eliminado exitosamente', null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->error('Error al eliminar el producto', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function searchProducto(Request $request)
    {
        try {
            $query = $request->input('query');
            $productos = Producto::with(['categoria', 'estado', 'detalleProducto', 'detalleProducto.genero'])
                ->where('nombre', 'LIKE', '%' . $query . '%')
                ->orWhereHas('detalleProducto', function ($q) use ($query) {
                    $q->where('codigo_producto', 'LIKE', '%' . $query . '%');
                })
                ->orderBy('created_at', 'desc')
                ->get();
            return $this->success('Productos encontrados', $productos, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error('Error al buscar productos', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
