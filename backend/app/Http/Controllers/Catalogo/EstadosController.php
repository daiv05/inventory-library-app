<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\EstadosEnum;
use App\Models\Catalogo\Estado;
use Illuminate\Support\Facades\Validator;
use App\Traits\ResponseTrait;

class EstadosController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'scope' => 'required|string|in:general,productos,all',
        ], [
            'scope.required' => 'Debe especificar un scope.',
            'scope.in' => 'El valor de flag no es válido. Debe ser uno de los siguientes: users, requests, surveys, all.',
        ]);

        if ($validator->fails()) {
            $this->validationError('Error de validación', $validator->errors(), 422);
        }

        $estados = [];
        $scope = $request->scope;
        if ($scope === 'general') {
            $estados = Estado::whereIn('id', EstadosEnum::general())->get();
        } elseif ($scope === 'productos') {
            $estados = Estado::whereIn('id', EstadosEnum::productos())->get();
        } else {
            $estados = Estado::all();
        }

        return $this->success('Estados obtenidos correctamente', $estados, 200);
    }
}
