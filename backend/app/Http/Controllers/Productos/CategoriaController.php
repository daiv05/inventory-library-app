<?php

namespace App\Http\Controllers\Productos;

use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use App\Models\Productos\Categoria;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\PaginationTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    use ResponseTrait, PaginationTrait;

    public function list()
    {
        try {
            $categorias = Categoria::with('estado')
                ->where('id_estado', '=', 1)
                ->orderBy('created_at', 'asc')
                ->get();
            return $this->success('Categorias obtenidas exitosamente', $categorias, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error('Error al obtener las categorias', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index()
    {
        try {
            $categorias = Categoria::with('estado')
                ->orderBy('created_at', 'asc')
                ->get();
            $paginatedData = $this->paginate($categorias->toArray(), request('per_page', GeneralEnum::PAGINACION->value), request('page', 1));
            return $this->successPaginated('Categorias obtenidas exitosamente', $paginatedData, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error('Error al obtener las categorias', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'nombre' => 'required|string|max:50',
                'descripcion' => 'string|max:255|nullable',
                'id_estado' => 'integer|exists:ctl_estados,id',
            ], [
                'nombre.required' => 'El campo nombre es obligatorio.',
                'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
                'nombre.max' => 'El campo nombre no puede tener más de 50 caracteres.',
                'descripcion.string' => 'El campo descripcion debe ser una cadena de texto.',
                'descripcion.max' => 'El campo descripcion no puede tener más de 255 caracteres.',
                'id_estado.integer' => 'El campo id_estado debe ser un número entero.',
                'id_estado.exists' => 'No se encontró el estado especificado.',
            ]);

            if ($validation->fails()) {
                return $this->validationError('Error de validación', $validation->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            DB::beginTransaction();
            $categoria = Categoria::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'id_estado' => $request->id_estado ?? 1, // Asignar estado activo por defecto
            ]);
            DB::commit();

            return $this->success('Categoria creada exitosamente', $categoria, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Error al crear la categoria', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $categoria = Categoria::with('estado')->findOrFail($id);
            return $this->success('Categoria obtenida exitosamente', $categoria, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error('Error al obtener la categoria', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validation = Validator::make($request->all(), [
                'nombre' => 'string|max:50',
                'descripcion' => 'string|max:255|nullable',
                'id_estado' => 'integer|exists:ctl_estados,id',
            ], [
                'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
                'nombre.max' => 'El campo nombre no puede tener más de 50 caracteres.',
                'descripcion.string' => 'El campo descripcion debe ser una cadena de texto.',
                'descripcion.max' => 'El campo descripcion no puede tener más de 255 caracteres.',
                'id_estado.integer' => 'El campo id_estado debe ser un número entero.',
                'id_estado.exists' => 'No se encontró el estado especificado.',
            ]);

            if ($validation->fails()) {
                return $this->validationError('Error de validación', $validation->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            DB::beginTransaction();
            $categoria = Categoria::findOrFail($id);
            $categoria->update($request->only(['nombre', 'descripcion', 'id_estado']));
            $categoria->save();
            DB::commit();

            return $this->success('Categoria actualizada exitosamente', $categoria, Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Error al actualizar la categoria', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $categoria = Categoria::findOrFail($id);
            // Verificar si la categoria tiene productos asociados
            if ($categoria->productos()->exists()) {
                return $this->error('No se puede eliminar la categoria porque tiene productos asociados', '', Response::HTTP_CONFLICT);
            }
            $categoria->delete();
            DB::commit();

            return $this->success('Categoria eliminada exitosamente', null, Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Error al eliminar la categoria', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
