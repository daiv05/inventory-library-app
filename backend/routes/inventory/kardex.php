<?php

use App\Http\Controllers\Inventario\KardexController;
use Illuminate\Support\Facades\Route;

Route::get('/kardex', [KardexController::class, 'index'])->name('kardex.index');
Route::post('/registrar-movimiento', [KardexController::class, 'registrarMovimiento'])->name('kardex.registrarMovimiento');