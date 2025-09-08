<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\Matricula;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
    }
}
