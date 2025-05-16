<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seguridad\Auth\AuthController;
use App\Http\Controllers\Seguridad\Auth\AuthRegistrationController;

Route::prefix('auth')->group(function () {
  Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
  // Route::post('/request-registration', [AuthRegistrationController::class, 'requestRegistration'])->name('auth.request-registration');
});
