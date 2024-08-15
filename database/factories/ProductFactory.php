<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cost = fake()->randomFloat(2, 1, 500);
        $saleValue = fake()->randomFloat(2, 500, 1000);

        return [
            'productName' => fake()->word(),
            'description' => fake()->sentence(),
            'cost' => $cost,
            'saleValue' => $saleValue,
            'inStock' => fake()->numberBetween(10, 100),
            'markup' => (($saleValue - $cost) / $cost) * 100
        ];
    }
}
