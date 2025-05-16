<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            [
                'nombre' => 'Producto 1',
                'id_categoria' => 1,
                'id_estado' => 1,
                'descripcion' => 'Descripción del producto 1',
                'precio_actual' => 0,
                'stock_actual' => 0
            ],
            [
                'nombre' => 'Producto 2',
                'id_categoria' => 2,
                'id_estado' => 1,
                'descripcion' => 'Descripción del producto 2',
                'precio_actual' => 0,
                'stock_actual' => 0
            ],
        ];

        foreach ($productos as $producto) {
            DB::table('prd_productos')->insert([
                'nombre' => $producto['nombre'],
                'id_categoria' => $producto['id_categoria'],
                'id_estado' => $producto['id_estado'],
                'descripcion' => $producto['descripcion'],
                'precio_actual' => $producto['precio_actual'],
                'stock_actual' => $producto['stock_actual'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
