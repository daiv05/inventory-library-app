<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use App\Models\Productos\Genero;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class GeneroController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        try {
            $generos = Genero::all();
            return $this->success('Géneros obtenidos correctamente', $generos, 200);
        } catch (\Exception $e) {
            return $this->error('Error al obtener los géneros', $e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Genero $genero)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genero $genero)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genero $genero)
    {
        //
    }
}
