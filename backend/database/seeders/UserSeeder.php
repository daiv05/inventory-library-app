<?php

namespace Database\Seeders;

use App\Models\Seguridad\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Enums\EstadosEnum;
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'id_persona' => 1,
                'username' => 'Administrador',
                'email' => 'administrador@yopmail.com',
                'password' => bcrypt('pass123'),
                'role' => 'ADMINISTRADOR',
                'id_estado' => EstadosEnum::ACTIVO->value,
            ],
            [
                'id_persona' => 2,
                'username' => 'Jefe Inventario 01',
                'email' => 'jefe.inventario01@yopmail.com',
                'password' => bcrypt('pass123'),
                'role' => 'JEFE DE INVENTARIO',
                'id_estado' => EstadosEnum::ACTIVO->value,
            ],
            [
                'id_persona' => 3,
                'username' => 'Jefe Inventario 02',
                'email' => 'jefe.inventario02@yopmail.com',
                'password' => bcrypt('pass123'),
                'role' => 'JEFE DE INVENTARIO',
                'id_estado' => EstadosEnum::ACTIVO->value,
            ],
        ];

        foreach ($usuarios as $usuario) {
            $user = User::create(
                [
                    'id_persona' => $usuario['id_persona'],
                    'username' => $usuario['username'],
                    'email' => $usuario['email'],
                    'password' => $usuario['password'],
                    'id_estado' => $usuario['id_estado'],
                    'email_verified_at' => Carbon::now()
                ]
            );

            $user->assignRole($usuario['role']);
        }
    }
}
