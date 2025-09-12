<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Curso;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grupo>
 */
class GrupoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_grupo' => fake()->numberBetween(1, 10),
            'cupo_maximo' => fake()->numberBetween(20, 40),
            'curso_id' => Curso::factory(),
            'profesor_id' => User::factory(),
        ];
    }
}
