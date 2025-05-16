<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoMovimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Libros\TipoMovimiento::factory(10)->create();
        $tiposMovimiento = [
            [
                'nombre' => 'Ingreso',
            ],
            [
                'nombre' => 'Salida',
            ],
            [
                'nombre' => 'Devolución',
            ],
        ];

        foreach ($tiposMovimiento as $tipoMovimiento) {
            \App\Models\Catalogo\TipoMovimiento::create(
                [
                    'nombre' => $tipoMovimiento['nombre'],
                ]
            );
        }
    }
}
