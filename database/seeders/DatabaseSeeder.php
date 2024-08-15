<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(1)->create();
        // Product::factory(30)->create();
        // Client::factory(30)->create();
        // Sale::factory(30)->create();

        User::factory()->create([
            'email' => 'henriquesantos2277@gmail.com',
            'password' => 'password',
        ]);
    }
}
