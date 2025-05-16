<?php

use App\Http\Controllers\Productos\ProductoController;
use Illuminate\Support\Facades\Route;

Route::prefix('productos')->group(function () {
    Route::get('/', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/{id}', [ProductoController::class, 'show'])->name('productos.show');
    Route::post('/', [ProductoController::class, 'store'])->name('productos.store');
    Route::put('/{id}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});
