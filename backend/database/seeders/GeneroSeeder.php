<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Libros\Genero::factory(10)->create();
        $generos = [
            [
                'nombre' => 'Ficción',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'No Ficción',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'Ciencia Ficción',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'Fantasía',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'Misterio',
                'id_estado' => 1,
            ]
        ];

        foreach ($generos as $genero) {
            \App\Models\Productos\Genero::create(
                [
                    'nombre' => $genero['nombre'],
                    'id_estado' => $genero['id_estado'],
                ]
            );
        }
    }
}
