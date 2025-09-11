<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //método para crear usuarios
       $data =$request ->validate(); //validaciones se hacen en StoreUserRequest
       return response()->json([
        'mensaje' => 'Usuario creado exitosamente!!', 
        'user' => User::create($data)
       ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $id_user)
    {
        $user = User::find($id_user);

        if (!$user) {
            return response()->json(['message' => 'El usuario no se encontró :('], 404);
        }

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->validated());
        return response()->json([
            'mensaje' => 'Usuario actualizado exitosamente!!',
            'user' => $user
        ], 200);    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->User::find($user);
        if (!$user) {
            return response()->json(['message' => 'El usuario no se encontró :('], 404);
        }
        else {
            $user->delete();
            return response()->json(['message' => 'Usuario eliminado exitosamente!!'], 200);
        }
    }

}
