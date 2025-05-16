<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AutorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Libros\Autor::factory(10)->create();
        $autores = [
            [
                'nombre' => 'Gabriel García Márquez',
                'fecha_nacimiento' => '1927-03-06',
                'descripcion' => 'Escritor colombiano, ganador del Premio Nobel de Literatura.',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'J.K. Rowling',
                'fecha_nacimiento' => '1965-07-31',
                'descripcion' => 'Escritora británica, famosa por la serie de Harry Potter.',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'George R.R. Martin',
                'fecha_nacimiento' => '1948-09-20',
                'descripcion' => 'Escritor estadounidense, conocido por la serie de Canción de Hielo y Fuego.',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'J.R.R. Tolkien',
                'fecha_nacimiento' => '1892-01-03',
                'descripcion' => 'Escritor británico, conocido por El Señor de los Anillos.',
                'id_estado' => 1,
            ],
            [
                'nombre' => 'Agatha Christie',
                'fecha_nacimiento' => '1890-09-15',
                'descripcion' => 'Escritora británica, conocida por sus novelas de misterio.',
                'id_estado' => 1,
            ]
        ];

        foreach ($autores as $autor) {
            \App\Models\Productos\Autor::create(
                [
                    'nombre' => $autor['nombre'],
                    'fecha_nacimiento' => $autor['fecha_nacimiento'],
                    'descripcion' => $autor['descripcion'],
                    'id_estado' => $autor['id_estado'],
                ]
            );
        }
    }
}
