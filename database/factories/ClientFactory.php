<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{

    public function definition(): array
    {
        return [
            'clientName' => fake()->name(),
            'phoneNumber' => '('.fake()->randomNumber(2, true).') '.'9.'.fake()->randomNumber(4, true).'-'.fake()->randomNumber(4, true)
        ];
    }
}
