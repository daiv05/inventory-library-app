<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use App\Models\Productos\Autor;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class AutorController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        try {
            $autores = Autor::all();
            return $this->success('Autores obtenidos correctamente', $autores, 200);
        } catch (\Exception $e) {
            return $this->error('Error al obtener los autores', $e->getMessage(), 500);
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
    public function show(Autor $autor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Autor $autor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Autor $autor)
    {
        //
    }
}
