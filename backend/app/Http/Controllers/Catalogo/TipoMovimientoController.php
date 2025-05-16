<?php

namespace App\Http\Controllers\Catalogo;
use App\Http\Controllers\Controller;
use App\Models\Catalogo\TipoMovimiento;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class TipoMovimientoController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        try {
            $tiposMovimiento = TipoMovimiento::all();
            return $this->success('Tipos de movimiento obtenidos correctamente', $tiposMovimiento, 200);
        } catch (\Exception $e) {
            return $this->error('Error al obtener los tipos de movimiento', $e->getMessage(), 500);
        }
    }
}
