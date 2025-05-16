<?php

namespace App\Enums;

enum PermisosEnum: string
{
    // Para gestion de usuarios
    case USUARIO_VER = 'usuario_ver';
    case USUARIO_CREAR = 'usuario_crear';
    case USUARIO_ACTUALIZAR = 'usuario_actualizar';
    // Para gestion de productos
    case PRODUCTO_VER = 'producto_ver';
    case PRODUCTO_CREAR = 'producto_crear';
    case PRODUCTO_ACTUALIZAR = 'producto_actualizar';
    // Para gestion de autores
    case AUTOR_VER = 'autor_ver';
    case AUTOR_CREAR = 'autor_crear';
    case AUTOR_ACTUALIZAR = 'autor_actualizar';
    // Para gestion de categorias
    case CATEGORIA_VER = 'categoria_ver';
    case CATEGORIA_CREAR = 'categoria_crear';
    case CATEGORIA_ACTUALIZAR = 'categoria_actualizar';
    // Para gestion de kardex
    case KARDEX_VER = 'kardex_ver';
    case KARDEX_CREAR_MOVIMIENTO = 'kardex_crear_movimiento';
}
