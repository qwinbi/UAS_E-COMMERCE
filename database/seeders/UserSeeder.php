<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@email',
            'email_verified_at' => now(),
            'password' => Hash::make('1234'),
            'role' => 'admin',
        ]);

        // Create guest user
        User::create([
            'name' => 'Guest User',
            'email' => 'user@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('4321'),
            'role' => 'guest',
        ]);

        // Create additional guest users WITHOUT factory
        User::create([
            'name' => 'John Doe',
            'email' => 'john@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'guest',
        ]);

        User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'guest',
        ]);

        User::create([
            'name' => 'Bunny Lover',
            'email' => 'bunny@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'guest',
        ]);
    }
}