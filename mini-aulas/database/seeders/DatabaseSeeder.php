<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\Matricula;
use App\Models\User;
use App\Models\Curso;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
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
        $permissionRegistrar = app(PermissionRegistrar::class);
        $permissionRegistrar->forgetCachedPermissions();

        $permissions = [
            // Permisos de Usuarios
            'create_user',
            'view_user',
            'update_user',
            'delete_user',

            // Permisos de Cursos
            'create_course',
            'view_course',
            'update_course',
            'delete_course',
            'enroll_course',
            'unenroll_course',

            // Permisos de Grupos
            'create_group',
            'view_group',
            'update_group',
            'delete_group',
            'enroll_group',
            'unenroll_group',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Crear los roles y asignar sus permisos
        $adminRole = Role::findOrCreate('admin');
        $professorRole = Role::findOrCreate('profesor');
        $studentRole = Role::findOrCreate('estudiante');

        // Asignar todos los permisos al rol de 'admin'
        $adminRole->givePermissionTo(Permission::all());

        // Asignar permisos al rol de 'profesor'
        $professorRole->givePermissionTo([
            'create_group',
            'view_group',
            'update_group',
            'delete_group',
        ]);

        // Asignar permisos al rol de 'estudiante'
        $studentRole->givePermissionTo([
            'view_course',
            'view_group',
            'enroll_course',
            'unenroll_course',
            'enroll_group',
            'unenroll_group',
        ]);

        //Asignar roles a los usuarios de test
        $adminUser = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $adminUser->assignRole('admin');

        $professorUser = User::factory()->create([
            'name' => 'Profesor',
            'email' => 'professor@example.com',
            'password' => Hash::make('password'),
        ]);
        $professorUser->assignRole('profesor');

        $studentUser = User::factory()->create([
            'name' => 'Estudiante',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
        ]);
        $studentUser->assignRole('estudiante');

        $permissionRegistrar->forgetCachedPermissions();

        // Crear 8 usuarios adicionales con rol de estudiante
        for ($i = 1; $i <= 8; $i++) {
            $studentUser = User::factory()->create([
                'name' => "estudianteTest$i",
                'email' => "student$i@example.com",
                'password' => Hash::make("password"),
            ]);


            $studentUser->assignRole('estudiante');
        }

            // Para cada curso creado, crear 2 grupos
            // Crear cursos
        Curso::factory(5)->create();

        // Para cada curso creado, crear 2 grupos
        Curso::all()->each(function ($curso) {
            $profesor = User::role('profesor')->inRandomOrder()->first();

            if ($profesor) {
                Grupo::factory(1)->create([
                    'curso_id' => $curso->id,
                    'profesor_id' => $profesor->id,
                ]);
            }
        });


        // gets all students and groups
        $estudiantes = User::role('estudiante')->get();
        $grupos = Grupo::all();

        // it make one enrollment for each student
        foreach ($estudiantes as $estudiante) {
            // it gets a random group
            $grupo = $grupos->random();
            // avoid duplicate enrollments
            Matricula::firstOrCreate([
                'user_id' => $estudiante->id,
                'grupo_id' => $grupo->id,
            ]);
        }
    }
}
