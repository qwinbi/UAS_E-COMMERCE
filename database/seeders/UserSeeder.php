<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@email',
            'password' => Hash::make('1234'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Guest User',
            'email' => 'user@email.com',
            'password' => Hash::make('4321'),
            'role' => 'guest',
        ]);

        // Create additional guest users
        User::factory()->count(5)->create([
            'role' => 'guest',
        ]);
    }
}