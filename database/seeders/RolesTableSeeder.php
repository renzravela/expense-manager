<?php

namespace Database\Seeders;

use App\Models\Roles; // Ensure you have a Role model
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
