<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matricula>
 */
class MatriculaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
    {
        return [
            
        ];
    }
    //this method garantire a unique combination
    public function forUniqueCombination(int $userId, int $groupId): Factory
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $userId,
            'grupo_id' => $groupId,
        ]);
    }
}
