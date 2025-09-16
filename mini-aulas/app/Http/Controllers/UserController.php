<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'mensaje' => 'Lista de usuarios obtenida correctamente',
            'data'    => $users,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //método para crear usuarios
        $data = $request->validated(); //validaciones se hacen en StoreUserRequest
        unset($data['id']); //para evitar que se asigne un id manualmente
        //hashear la contraseña antes de guardarla
        $data['password'] = bcrypt($data['password']);

        return response()->json([
            'mensaje' => 'Usuario creado exitosamente!!',
            'user' => User::create($data)
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id_user)
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
    public function update(UpdateUserRequest $request, User $user)
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
    public function destroy($id_user)
    {
        $id_user = User::find($id_user);
        if (!$id_user) {
            return response()->json(['message' => 'El usuario no se encontró :('], 404);
        } else {
            $id_user->delete();
            return response()->json(['message' => 'Usuario eliminado exitosamente!!'], 200);
        }
    }
}
