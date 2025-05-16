<?php

namespace App\Http\Controllers\Inventario;

use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use App\Models\Inventario\Kardex;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Traits\PaginationTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class KardexController extends Controller
{
    use ResponseTrait, PaginationTrait;

    public function index()
    {
        try {
            $kardex = Kardex::all();
            $paginatedData = $this->paginate($kardex->toArray(), request('per_page', GeneralEnum::PAGINACION->value), request('page', 1));
            return $this->successPaginated('Kardex obtenidos exitosamente', $paginatedData, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->error('Error al obtener los kardex', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function registrarMovimiento(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'id_producto' => 'required|integer|exists:prd_productos,id',
                'id_tipo_movimiento' => 'required|integer|exists:ctl_tipos_movimientos,id',
                'cantidad' => 'required|integer',
                'precio_unitario' => 'required|numeric',
                'observaciones' => 'string|max:255|nullable',
            ], [
                'id_producto.required' => 'El campo id_producto es obligatorio.',
                'id_producto.integer' => 'El campo id_producto debe ser un número entero.',
                'id_producto.exists' => 'No se encontró el producto especificado.',
                'id_tipo_movimiento.required' => 'El campo id_tipo_movimiento es obligatorio.',
                'id_tipo_movimiento.integer' => 'El campo id_tipo_movimiento debe ser un número entero.',
                'id_tipo_movimiento.exists' => 'No se encontró el tipo de movimiento especificado.',
                'cantidad.required' => 'El campo cantidad es obligatorio.',
                'cantidad.integer' => 'El campo cantidad debe ser un número entero.',
                'precio_unitario.required' => 'El campo precio_unitario es obligatorio.',
                'precio_unitario.numeric' => 'El campo precio_unitario debe ser un número.',
                'observaciones.string' => 'El campo observaciones debe ser una cadena de texto.',
                'observaciones.max' => 'El campo observaciones no puede tener más de 255 caracteres.',
            ]);

            if ($validation->fails()) {
                return $this->validationError('Error de validación', $validation->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            DB::beginTransaction();
            $kardex = Kardex::create([
                'id_producto' => $request->id_producto,
                'id_tipo_movimiento' => $request->id_tipo_movimiento,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $request->precio_unitario,
                'observaciones' => $request->observaciones,
                'id_usuario_registro' => JWTAuth::user()->id,
            ]);

            // Actualizar el stock del producto
            $producto = $kardex->producto;
            if ($request->id_tipo_movimiento == 1) { // Ingreso
                $producto->stock_actual += $request->cantidad;
            } else { // Salida
                $producto->stock_actual -= $request->cantidad;
            }

            // Actualizar el precio actual (promedio ponderado)
            if ($producto->precio_actual == 0) {
                $producto->precio_actual = $request->precio_unitario;
            } else {
                $totalStock = $producto->stock_actual;
                $totalValor = $producto->precio_actual * $totalStock;
                $nuevoValor = $request->precio_unitario * $request->cantidad;
                $nuevoTotalValor = $totalValor + $nuevoValor;
                $nuevoPrecioUnitario = $nuevoTotalValor / ($totalStock + $request->cantidad);
                $producto->precio_actual = $nuevoPrecioUnitario;
            }


            $producto->save();

            DB::commit();
            return $this->success('Movimiento registrado exitosamente', $kardex, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error('Error al registrar el movimiento', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
