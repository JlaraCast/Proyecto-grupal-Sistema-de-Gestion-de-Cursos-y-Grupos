<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMatricula;
use App\Models\Matricula;
use App\Models\Grupo;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Matricula::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatricula $request)
    {


        // Only students and admins can create enrollments
        if (!JWTAuth::user()->hasAnyRole('estudiante', 'admin')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        //verifies if user is student and change user id by her own id
        if (JWTAuth::user()->hasAnyRole('estudiante')) {
            $userId = JWTAuth::user()->id;
            $data['user_id'] = $userId;
        }

        $data = $request->validated();
        //validate if user_id exits in data array
        if (!isset($data['user_id'])) {
            return response()->json(['message' => 'El campo user_id es obligatorio.'], 400);
        }

        $group = Grupo::find($data['grupo_id']);

        // Count current enrollments in the group
        $actualEnrollments = Matricula::where('grupo_id', $group->id)->count();

        // Validate capacity
        if ($group->cupo_maximo !== null && $actualEnrollments >= $group->cupo_maximo) {
            return response()->json(['message' => 'El grupo ya alcanzó su capacidad máxima de estudiantes.'], 400);
        }

        // validates if the student is already enrolled in the group
        $alredyM = Matricula::where('user_id', $data['user_id'])
            ->where('grupo_id', $data['grupo_id'])
            ->exists();

        if ($alredyM) {
            return response()->json(['message' => 'El estudiante ya está matriculado en este grupo.'], 400);
        }

        $post = Matricula::create($data);
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Matricula::find($id);

        if (!$post) {
            return response()->json(['message' => 'La matrícula no se encontró '], 404);
        }
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $matricula = Matricula::find($id);

        // Only students can delete their own enrollments
        if (!JWTAuth::user()->hasAnyRole('estudiante', 'admin')) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        // Check if the enrollment exists
        if (!$matricula) {
            return response()->json(['message' => 'La matrícula no se encontró'], 404);
        }
        // Check if the authenticated user is the owner of the enrollment
        if (JWTAuth::user()->hasRole('estudiante') && $matricula->user_id !== JWTAuth::user()->id) {
            return response()->json(['message' => 'Solo puedes eliminar tus propias matriculas'], 403);
        }
        $matricula->delete();
        return response()->json(['message' => 'La matrícula ha sido eliminada con éxito.']);
    }
}
