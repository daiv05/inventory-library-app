<?php

namespace App\Http\Controllers\Seguridad\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    use ResponseTrait;

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                return $this->error('No se pudo iniciar sesión. Por favor verifique sus credenciales', '', Response::HTTP_UNAUTHORIZED);
            }
            $data = [
                'accessToken' => $token,
                'expires_in' => JWTAuth::factory()->getTTL()
            ];
            return $this->success('Inicio de sesión exitoso', $data, Response::HTTP_OK);
        } catch (JWTException $e) {
            return $this->error('No se pudo iniciar sesión. Por favor vuelva a intentar', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('api')->logout();
            return $this->success('Cierre de sesión exitoso', null, Response::HTTP_OK);
        } catch (JWTException $e) {
            return $this->error('No se pudo cerrar sesión. Por favor vuelva a intentar', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function refresh(Request $request)
    {
        try {
            $newToken = JWTAuth::refresh($request->input('token'));
            $data = [
                'accessToken' => $newToken,
                'expires_in' => JWTAuth::factory()->getTTL()
            ];
            return $this->success('Token refrescado exitosamente', $data, Response::HTTP_OK);
        } catch (JWTException $e) {
            return $this->error('No se pudo refrescar el token. Por favor vuelva a intentar', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
