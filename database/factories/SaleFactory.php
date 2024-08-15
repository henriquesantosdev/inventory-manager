<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'clientId' => fake()->numberBetween(1, 30),
            'productId' => fake()->numberBetween(1, 30),
            'quantity' => fake()->numberBetween(10, 20),
        ];
    }
}
