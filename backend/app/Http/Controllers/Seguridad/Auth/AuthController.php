<?php

namespace App\Http\Controllers\Seguridad\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        if (!$token) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        return response()->json([
            'accessToken' => $token,
            'expires_in' => JWTAuth::factory()->getTTL()
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Sesión cerrada con éxito']);
    }

    public function refresh(Request $request)
    {
        try {
            $newToken = JWTAuth::refresh($request->input('token'));
            return response()->json([
                'accessToken' => $newToken,
                'expires_in' => JWTAuth::factory()->getTTL()
            ]);
        } catch (JWTException $e) {
            return response()->json(['message' => 'No se puedo recuperar la sesión'], 401);
        }
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
