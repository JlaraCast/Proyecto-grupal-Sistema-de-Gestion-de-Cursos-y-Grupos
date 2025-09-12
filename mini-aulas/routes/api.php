<?php

use App\Http\Controllers\MatriculaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\GrupoController;
use App\Http\Middleware\JwtMiddleware;

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);
Route::get('/me', [AuthController::class, 'me']);

// Rutas protegidas
Route::middleware([JwtMiddleware::class])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // CURSOS
    Route::get('cursos', [CursoController::class, 'index']);
    Route::get('cursos/{id}', [CursoController::class, 'show']);
    Route::post('cursos', [CursoController::class, 'store']); // Solo admin
    Route::put('cursos/{id}', [CursoController::class, 'update']); // Solo admin
    Route::delete('cursos/{id}', [CursoController::class, 'destroy']); // Solo admin

    // GRUPOS
    Route::get('grupos', [GrupoController::class, 'index']);
    Route::get('grupos/{id}', [GrupoController::class, 'show']);
    Route::post('grupos', [GrupoController::class, 'store']); // Admin + profesor
    Route::put('grupos/{id}', [GrupoController::class, 'update']); // Admin + profesor
    Route::delete('grupos/{id}', [GrupoController::class, 'destroy']); // Solo admin

});
