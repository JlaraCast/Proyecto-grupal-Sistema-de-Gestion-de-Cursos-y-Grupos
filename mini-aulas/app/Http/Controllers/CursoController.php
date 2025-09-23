<?php

namespace App\Http\Controllers;

use App\Http\Requests\CursoRequests\UpdateCursoRequest;
use App\Models\Curso;
use Illuminate\Http\Request;
use Exception;
use App\Http\Requests\CursoRequests\StoreCursoRequest;
use App\Services\CursoService;
use Namshi\JOSE\JWT;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cursos = Curso::all();
            return response()->json($cursos, 200);
            
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Hubo un error al recuperar los cursos.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCursoRequest $request, CursoService $cursoService)
    {
        try {
            if (!JWTAuth::user()->hasRole('admin')) {
                return response()->json(['message' => 'No autorizado'], 403);
            }

            $validatedData = $request->validated();
            $curso = $cursoService->crearCurso($validatedData);
            return response()->json($curso, 201);

        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Hubo un error al crear el curso.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, CursoService $cursoService)
    {
        $response = $cursoService->getCursoById($id);
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCursoRequest $request, String $id, CursoService $cursoService)
    {
        if (!JWTAuth::user()->hasRole('admin')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $response = $cursoService->actualizarCurso($id, $request->validated());
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id, CursoService $cursoService)
    {
        if (!JWTAuth::user()->hasRole('admin')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $response = $cursoService->eliminarCurso($id);
        return response()->json($response, 200);
    }
}
