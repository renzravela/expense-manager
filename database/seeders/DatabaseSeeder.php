<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Roles;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'user_type' => 'User',
        ]);

        $roles = [
            ['name' => 'Administrator'],
            ['name' => 'User'],
            // Add more roles as needed
        ];

        foreach ($roles as $role) {
            Roles::create($role);
        }
    }
}
