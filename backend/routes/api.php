<?php

use Illuminate\Support\Facades\Route;

/**
 * AUTH MIDDLEWARE
 * Rutas con validación de token y
 * autenticación de usuario.
 */
Route::middleware('auth:api')->group(function () {
    /**
     * VALID USER MIDDLEWARE
     * Rutas con validación de token y
     * restricción de acceso a usuarios validos.
     */
    Route::middleware('validate.user')->group(function () {

        // Seguridad y autenticación
        Route::prefix('auth')->group(function () {
            require __DIR__ . '/auth/users.php';
            require __DIR__ . '/auth/authentication.php';
        });

        // Catalogos
        Route::prefix('catalogos')->group(function () {
            require __DIR__ . '/catalogues/catalogs.php';
        });

        // Inventario
        Route::prefix('inventario')->group(function () {
            require __DIR__ . '/inventory/products.php';
            require __DIR__ . '/inventory/kardex.php';
        });
    });
});
