<?php

namespace App\Http\Middleware;

use Closure;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            // Tries to authenticate the user using the token
            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado.'], 404);
            }

            // Check if the user is active
            if ($user->status === 0) {
                return response()->json(['message' => 'Cuenta desactivada.'], 403);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token inválido o expirado.'], 401);
        }

        // Add the authenticated user to the request
        $request->auth = $user;
        return $next($request);
    }
}
