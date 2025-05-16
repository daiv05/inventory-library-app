<?php

namespace Database\Factories\Productos;

use App\Models\Productos\Producto;
use App\Models\Productos\Categoria;
use App\Models\Catalogo\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition()
    {
        return [
            'nombre' => fake()->words(2, true),
            'id_categoria' => Categoria::factory(),
            'id_estado' => Estado::factory(),
            'descripcion' => fake()->sentence(),
            'precio_actual' => fake()->randomFloat(2, 10, 1000),
            'stock_actual' => fake()->numberBetween(0, 100)
        ];
    }
}
