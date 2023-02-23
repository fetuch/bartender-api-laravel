<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()
                ->count(4)
                ->sequence(
                    ['name' => 'Ordinary Drink'],
                    ['name' => 'Shot'],
                    ['name' => 'Shake'],
                    ['name' => 'Beer'],
                )
                ->create();
    }
}
