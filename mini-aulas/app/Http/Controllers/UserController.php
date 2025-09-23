<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

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
        //lo de abajo es para que si algo falla en la creacion del usuario no se guarde nada en la base de datos
        //y se haga un rollback de todo lo que se haya hecho
        //ademas se intenta 5 veces en caso de que haya un deadlock
        $user = DB::transaction(function () use ($request) {

            $data = $request->validated(); // Obtener los datos validados, lo que se obtiene es un array con los datos del usuario

            $role = $data['role'] ?? null; // obtener el rol si se proporciona

            // Hashear la contraseña
            $data['password'] = Hash::make($data['password']);

            // Manejo de la imagen de perfil si se proporciona
            if ($request->hasFile('profile_image')) {
                $ext = $request->file('profile_image')->extension(); // obtener la extension del archivo
                $base = Str::slug($data['name']); // crear un slug del nombre para usarlo en el nombre del archivo
                // agregar un UUID para evitar colisiones de nombres de archivo
                $filename = $base . '-' . Str::uuid() . '.' . $ext; // nombre del archivo unico
                // almacenar la imagen en el disco 'public' dentro de la carpeta 'profiles'
                $path = $request->file('profile_image')->storeAs('profiles', $filename, 'public'); // guarda la ruta relativa
                $data['profile_image'] = $path; // guardar la ruta en el campo profile_image
            }

            $user = User::create($data); // crea el usuario

            if ($role) {
                $user->assignRole($role); // asigna el rol usando Spatie
            }

            return $user->load('roles:id,name'); // carga los roles para evitar consultas adicionales
        }, 5);

        return response()->json([
            'mensaje' => 'Usuario creado exitosamente!!',
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames()->values(),
                'profile_image'     => $user->profile_image,
                'profile_image_url' => $user->profile_image ? Storage::url($user->profile_image) : null,
            ],
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
         //se obtiene un array asociativo con los datos que pasaron la validación definida 
        //en la clase UpdateUserRequest
        $data = $request->validated();

        // Si en la petición viene un archivo en el campo 'profile_image' se procesa la nueva imagen
        if ($request->hasFile('profile_image')) {

            //Si el usuario ya tiene una imagen guardada y existe en el disco 'public'
            //eliminarla para no dejar archivos huérfanos
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            //Se guarda la nueva imagen en la carpeta profiles del disco public y se obtiene 
            //la ruta relativa
            $path = $request->file('profile_image')->store('profiles', 'public');

            //Se añade la ruta de la nueva imagen al array de datos para que se actualice en la BD
            $data['profile_image'] = $path;
        }

        //Si se envió una contraseña y no está vacía se debe de encripta antes de guardarla
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        //Se guarda el rol en una variable aparte (si se envió) y se elimina del array de datos
        //Esto se hace porque 'role' no es una columna en la tabla users
        $role = $data['role'] ?? null;
        unset($data['role']);

        // Actualizar en la base de datos los campos del usuario con los datos restantes
        $user->update($data);

        // Si se envió un rol, sincronizarlo usando el paquete Spatie 
        //reemplaza roles anteriores por el nuevo)
        if ($role) {
            $user->syncRoles([$role]);
        }

        // Devolver respuesta JSON con mensaje de éxito y datos actualizados del usuario
        return response()->json([
            'mensaje' => 'Usuario actualizado exitosamente!!',
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames()->values(), 
                'profile_image'     => $user->profile_image, 
                'profile_image_url' => $user->profile_image ? Storage::url($user->profile_image) : null, // URL pública de la imagen
            ],
        ], 200);
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_user)
    {
        //se cuenta cuantos administradores hay si solo queda uno no se deja eliminar
        $adminCount = User::where('role', 'admin')->count();
        $userToDelete = User::find($id_user);

        if (!$userToDelete) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        if ($userToDelete->role == 'admin' && $adminCount <= 1) {
            return response()->json(['message' => 'No se puede eliminar el último administrador.'], 400);
        } else {
            $userToDelete->delete();
            return response()->json(['message' => 'Usuario eliminado exitosamente!!'], 200);
        }
    }
}
