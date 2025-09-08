<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $data = $request->validated();
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
     * Update the specified resource in storage.
     */

    //this method is only made for fun and practice
    public function update(Request $request, Matricula $matricula)
    {
        $data = $request->validated();
        $matricula->update($data);
        return response()->json($matricula);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matricula $matricula)
    {
        $matricula->delete();
        return response()->json(['message' => 'La matrícula ha sido eliminada con éxito.']);
    }
}
