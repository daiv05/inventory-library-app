<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Libros\Categoria::factory(10)->create();
        $categorias = [
            [
                'nombre' => 'Libros',
                'descripcion' => 'Libros de diferentes géneros y autores.',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'Revistas',
                'descripcion' => 'Revistas de actualidad y entretenimiento.',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'Cómics',
                'descripcion' => 'Cómics de diferentes géneros y estilos.',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'Mapas',
                'descripcion' => 'Mapas de diferentes regiones y países.',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'Marcadores',
                'descripcion' => 'Marcadores de diferentes tipos y colores.',
                'id_estado' => 1,
            ]
        ];

        foreach ($categorias as $categoria) {
            \App\Models\Productos\Categoria::create(
                [
                    'nombre' => $categoria['nombre'],
                    'descripcion' => $categoria['descripcion'],
                    'id_estado' => $categoria['id_estado'],
                ]
            );
        }
    }
}
