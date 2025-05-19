<?php

use App\Http\Controllers\Productos\CategoriaController;
use App\Http\Controllers\Productos\ProductoController;
use Illuminate\Support\Facades\Route;

Route::prefix('productos')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/{id}', [ProductoController::class, 'show'])->name('productos.show');
    Route::post('/', [ProductoController::class, 'store'])->name('productos.store');
    Route::put('/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::get('/kardex/search', [ProductoController::class, 'searchProducto'])->name('productos.searchProducto');
});

Route::prefix('categorias')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/{id}', [CategoriaController::class, 'show'])->name('categorias.show');
    Route::post('/', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::put('/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
});
