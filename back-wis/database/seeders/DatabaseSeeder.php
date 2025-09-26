<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         \App\Models\User::factory()->create([
             'firstname' => 'admin',
             'name' => 'admin',
             'email' => 'admin@gmail.com',
             'role' => \App\Enums\UserRole::ADMIN,
             'password' => 'passer',
             'phoneNumber' => '7700000000',
         ]);
    }
}
