<?php

namespace Database\Seeders;

use App\Models\Categories; // Ensure you have a Category model
use Illuminate\Database\Seeder;

class ExpenseCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Food'],
            ['name' => 'Transportation'],
            ['name' => 'Utilities'],
            ['name' => 'Entertainment'],
            ['name' => 'Healthcare'],
        ];

        foreach ($categories as $category) {
            Categories::create($category);
        }
    }
}
