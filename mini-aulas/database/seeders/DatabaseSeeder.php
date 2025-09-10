<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\Matricula;
use App\Models\User;
use App\Models\Curso;
use App\Models\Grupo;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* 
        // Create 20 users, 20 groups, and enroll each user in a unique group
        for ($i = 0; $i < 20; $i++) {
            $user = User::factory()->create();
            $grupo = Grupo::factory()->create();
            // this method need the rest of factorys to function
            Matricula::factory()->forUniqueCombination($user->id,$grupo->id)->create();
        }
        */
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->profesor()->create([
            'name' => 'Profesor Ejemplo',
            'email' => 'profesor@example.com',
            'password' => bcrypt('profesor1234'),
        ]);

        User::factory()->estudiante()->create([
            'name' => 'Estudiante Ejemplo',
            'email' => 'estudiante@example.com',
            'password' => bcrypt('estudiante1234'),
        ]);

        // Crear más usuarios
        User::factory(5)->profesor()->create();
        User::factory(20)->estudiante()->create();

        // Crear cursos
        Curso::factory(10)->create();

        // Crear grupos para cada curso
        Curso::all()->each(function ($curso) {
            Grupo::factory(3)->create([
                'curso_id' => $curso->id,
                'profesor_id' => User::where('rol', 'profesor')->inRandomOrder()->first()->id,
            ]);
        });
    }
}
