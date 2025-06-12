<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\LabTest;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory()->hasAttached(LabTest::factory()->count(2))->create();
        Category::factory(5)->create();
        LabTest::factory(5)->create();
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
