<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(EstadoSeeder::class);
        $this->call(PermisoSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(CategoriaSeeder::class);
        $this->call(GeneroSeeder::class);
        $this->call(AutorSeeder::class);
        $this->call(TipoMovimientoSeeder::class);

        $this->call(ProductoSeeder::class);
    }
}
