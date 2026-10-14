<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            // 'title' => $this->faker->sentence(4), // Generates a random sentence with 4 words
            // 'description' => $this->faker->paragraph(3), // Generates a random paragraph with 3 sentences
            // 'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            // 'status' => $this->faker->boolean(), // Generates either true or false
            // 'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
