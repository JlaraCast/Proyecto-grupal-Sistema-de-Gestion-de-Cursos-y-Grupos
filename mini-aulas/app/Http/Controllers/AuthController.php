<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\AuthRequests\LoginRequest;
use Exception;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Unauthorized',
                    'message' => 'Credenciales inválidas'
                ], 401);
            }

            $user = Auth::user();

            return $this->respondWithToken($token, $user);
            
        } catch (Exception $e) {
            return response()->json(['error' => 'No se pudo iniciar sesión'], 500);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            $user = JWTAuth::user();
            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }
            $user->role_name = ucfirst($user->roles()->first()->name);
            unset($user->roles);

            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error al obtener el usuario'], 500);
        }
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (Exception $e) {
            return response()->json(['error' => 'no se pudo cerrar sesión'], 500);
        }

        return response()->json(['message' => 'Sesión cerrada con éxito']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
