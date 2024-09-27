<?php

namespace Database\Seeders;

use App\Models\Expenses; // Ensure you have an Expense model
use App\Models\User;    // Import User model
use App\Models\Categories; // Import Category model
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $user = User::first(); // Get the first user or adjust as necessary
        $categories = Categories::all(); // Get all categories

        if ($user && $categories->count() > 0) {
            foreach (range(1, 10) as $index) {
                Expenses::create([
                    'user_id' => $user->id,
                    'category_id' => $categories->random()->id, // Random category
                    'amount' => $faker->randomFloat(2, 1, 1000), // Random amount between 1 and 1000
                    'description' => $faker->sentence(3), // Random description
                    'date' => $faker->date(), // Random date
                ]);
            }
        }
    }
}
