<?php

use App\Http\Controllers\Inventario\KardexController;
use Illuminate\Support\Facades\Route;

Route::get('/kardex', [KardexController::class, 'index'])->name('kardex.index');
Route::get('/kardex/{id}', [KardexController::class, 'show'])->name('kardex.show');
Route::post('/registrar-movimiento', [KardexController::class, 'registrarMovimiento'])->name('kardex.registrarMovimiento');