<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ResponseTrait;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtValidator
{
    use ResponseTrait;

    public function handle(Request $request, Closure $next): Response
    {
        $error = true;
        $message = '';

        try {
            // Revisar si el token de sesión está presente
            if (!$request->hasHeader('Authorization')) {
                return $this->error('No se ha proporcionado un token de sesión', '', 401);
            }
            // Obtener el token de sesión
            $token = $request->bearerToken();
            if (!$token) {
                return $this->error('No se ha proporcionado un token de sesión', '', 401);
            }
            // Validar el token de sesión
            $user = JWTAuth::setToken($token)->checkOrFail();
            // Si el token es válido, obtener el usuario autenticado
            $user = JWTAuth::parseToken()->authenticate();
            if ($user) {
                $error = false;
            }
        } catch (TokenInvalidException $e) {
            $message = 'Ha proporcionado un token de sesión inválido';
        } catch (TokenExpiredException $e) {
            $message = 'Su token de sesión ha expirado';
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        return ($error) ? $this->error($message, $message, 401) : $next($request);
    }
}
