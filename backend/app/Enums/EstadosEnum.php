<?php

namespace App\Enums;

enum EstadosEnum: int
{
    case ACTIVO = 1;
    case INACTIVO = 2;
    case SIN_STOCK = 3;

    // Estados de encuesta
    public static function general(): array
    {
        return [
            self::ACTIVO,
            self::INACTIVO,
        ];
    }

    // Estados de usuario
    public static function productos(): array
    {
        return [
            self::ACTIVO,
            self::INACTIVO,
            self::SIN_STOCK,
        ];
    }
}