<?php

namespace Database\Factories;

use App\Models\Celebrant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class GreetingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'message' => fake()->text(),
            'celebrant_id' => fake()->randomElement(Celebrant::pluck('id')->toArray()),
        ];
    }
}