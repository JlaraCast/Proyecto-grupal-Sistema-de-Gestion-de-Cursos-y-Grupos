<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;

use Spatie\Permission\Exceptions\UnauthorizedException as SpatieUnauthorized;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException as LaravelAuthorization;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException as SymfonyAccessDenied;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    // Configura Spatie Permission
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })

    // Configura manejo de excepciones personalizado
    //Aquí se manejan los errores 401 y 403 que son: el no autenticado y el acceso denegado
    ->withExceptions(function (Exceptions $exceptions) {
        // Error 401: no autenticado (sin token o token inválido)
        $exceptions->render(function (AuthenticationException $e, $request) {
            return response()->json([
                'error' => 'No se encuentra autenticado',
                'message' => 'Debe iniciar sesión para acceder a esta ruta.',
            ], 401);
        });

        // Error 403 de Spatie (rol/permiso no cumple)
        $exceptions->render(function (SpatieUnauthorized $e, $request) {
            return response()->json([
                'error' => 'Acceso denegado',
                'message' => 'No cuenta con el rol o permiso requerido para acceder a esta ruta.',
            ], 403);
        });
    })
    ->create(); 
