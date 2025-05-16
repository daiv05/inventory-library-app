<?php

namespace Database\Factories\Productos;

use App\Models\Catalogo\Estado;
use App\Models\Productos\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition()
    {
        return [
            'nombre' => fake()->word(),
            'descripcion' => fake()->sentence(),
            'id_estado' => Estado::factory(),
        ];
    }
}
