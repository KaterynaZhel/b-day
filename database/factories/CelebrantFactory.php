<?php

namespace Database\Factories;

use App\Casts\CelebrantPosition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CelebrantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lastname' => fake()->lastName(),
            'firstname' => fake()->firstName(),
            'middlename' => fake()->name(),
            'birthday' => fake()->date('Y-m-d'),
            'position' => fake()->randomElement(CelebrantPosition::$positions),
        ];
    }
}