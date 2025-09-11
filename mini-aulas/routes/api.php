<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\GrupoController;
use App\Models\Grupo;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\UserController;

//todos pueden acceder a login y me
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me']);
Route::post('/logout', [AuthController::class, 'logout']);

//rutas protegidas
    Route::apiResource('cursos', CursoController::class);
    Route::apiResource('grupos', GrupoController::class);

//users
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('users', UserController::class);
});