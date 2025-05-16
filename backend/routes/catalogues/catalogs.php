<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Catalogo\EstadosController;
use App\Http\Controllers\Catalogo\TipoMovimientoController;
use App\Http\Controllers\Productos\AutorController;
use App\Http\Controllers\Productos\GeneroController;

Route::get('/estados', [EstadosController::class, 'index'])->name('estados.index');
Route::get('/tipos-movimientos', [TipoMovimientoController::class, 'index'])->name('tipos-movimientos.index');
Route::get('/autores', [AutorController::class, 'index'])->name('autores.index');
Route::get('/generos', [GeneroController::class, 'index'])->name('generos.index');
