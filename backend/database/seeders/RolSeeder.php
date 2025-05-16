<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\PermisosEnum;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nombre' => 'ADMINISTRADOR',
                'permisos' => PermisosEnum::cases(),
                'descripcion' => 'Rol con todos los permisos del sistema',
            ],
            [
                'nombre' => 'JEFE DE INVENTARIO',
                'permisos' => [
                    PermisosEnum::PRODUCTO_VER->value,
                    PermisosEnum::PRODUCTO_CREAR->value,
                    PermisosEnum::PRODUCTO_ACTUALIZAR->value,
                    PermisosEnum::AUTOR_VER->value,
                    PermisosEnum::AUTOR_CREAR->value,
                    PermisosEnum::AUTOR_ACTUALIZAR->value,
                    PermisosEnum::CATEGORIA_VER->value,
                    PermisosEnum::CATEGORIA_CREAR->value,
                    PermisosEnum::CATEGORIA_ACTUALIZAR->value,
                    PermisosEnum::KARDEX_VER->value,
                    PermisosEnum::KARDEX_CREAR_MOVIMIENTO->value,
                ],
                'descripcion' => 'Rol para jefes de inventario',
            ],
        ];

        foreach ($roles as $rol) {
            $role = Role::create([
                'name' => $rol['nombre'],
                'description' => $rol['descripcion'],
                'activo' => true,
                'guard_name' => 'api'
            ]);
            foreach ($rol['permisos'] as $perm) {
                $role->givePermissionTo($perm);
            }
        }
    }
}
