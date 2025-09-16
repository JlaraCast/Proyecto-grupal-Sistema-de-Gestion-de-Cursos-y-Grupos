<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use Exception;
use App\Services\GrupoService;
use App\Http\Requests\GrupoRequests\StoreGrupoRequest;
use App\Http\Requests\GrupoRequests\UpdateGrupoRequest;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class GrupoController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $grupos = Grupo::all();
            return response()->json($grupos, 200);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Hubo un error al recuperar los grupos.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGrupoRequest $request, GrupoService $grupoService)
    {
        try {
            if (!JWTAuth::user()->hasAnyRole(['admin', 'profesor'])) {
                return response()->json(['message' => 'No autorizado'], 403);
            }

            $validatedData = $request->validated();
            $grupo = $grupoService->crearGrupo($validatedData);
            return response()->json($grupo, 201);
        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Hubo un error al crear el grupo.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $grupo, GrupoService $grupoService)
    {
        $response = $grupoService->getGrupoById($grupo);
        return response()->json($response, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGrupoRequest $request, GrupoService $grupoService, string $id)
    {
        $grupo = Grupo::find($id);
        if (JWTAuth::user()->hasRole('profesor') && $grupo->profesor_id !== JWTAuth::User()->id) {
            return response()->json(['message' => 'Solo puedes editar tus grupos'], 403);
        }

        if (!JWTAuth::user()->hasAnyRole(['admin', 'profesor'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $response = $grupoService->actualizarGrupo($id, $request->validated());
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id, GrupoService $grupoService)
    {

        $grupo = Grupo::find($id);
        if (JWTAuth::user()->hasRole('profesor') && $grupo->profesor_id !== JWTAuth::User()->id) {
            return response()->json(['message' => 'Solo puedes editar tus grupos'], 403);
        }

        if (!JWTAuth::user()->hasAnyRole(['admin', 'profesor'])) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $response = $grupoService->eliminarGrupo($id);
        return response()->json($response, 200);
    }
}
