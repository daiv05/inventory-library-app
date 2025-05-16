<?php

namespace Database\Factories\Catalogo;

use App\Models\Catalogo\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstadoFactory extends Factory
{
    protected $model = Estado::class;

    public function definition()
    {
        return [
            'nombre' => fake()->word(),
            'activo' => true
        ];
    }
}
