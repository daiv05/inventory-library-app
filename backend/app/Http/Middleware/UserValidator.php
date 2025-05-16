<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class UserValidator
{
    use ResponseTrait;

    public function handle(Request $request, Closure $next): Response
    {
       $user = $request->user('api');

        // Usuario SUPERADMIN por defecto
        if ($user->id === 1) {
            return $next($request);
        }

        // Usuario estado activo (1)
        if ($user->id_estado !== 1) {
            $message = 'El usuario se encuentra inactivo dentro del sistema';
            Auth::guard('api')->logout();
            return $this->error('Error de autenticación', $message, Response::HTTP_UNAUTHORIZED);
        }

        // Posee al menos un rol activo
        $validRole = 0;
        $user->roles->each(function ($rol) use (&$validRole) {
            if ($rol->activo === true) {
                $validRole++;
            }
        });

        if (!$validRole) {
            $message = 'El usuario no posee un rol activo dentro del sistema';
            Auth::guard('api')->logout();
            return $this->error('Error de autenticación', $message, Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
