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
             'phoneNumber' => '770000000',
         ]);

        \App\Models\User::factory()->create([
            'firstname' => 'test',
            'name' => 'test',
            'email' => 'test@gmail.com',
            'role' => \App\Enums\UserRole::RECRUITER,
            'password' => 'passer',
            'phoneNumber' => '770000001',
        ]);

        \App\Models\User::factory()->create([
            'firstname' => 'User',
            'name' => 'User',
            'email' => 'user@example.com',
            'role' => \App\Enums\UserRole::RECRUITER,
            'password' => 'string',
            'phoneNumber' => '770000002',
        ]);

        $this->call([
            CodeListSeeder::class,
            SubscriptionOfferSeeder::class,
            SkillSeeder::class,
        ]);



    }
}
