<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Drink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Drink>
 */
class DrinkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Drink::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoriesCount = Category::count();

        return [
            'name' => fake()->sentence(3),
            'instructions' => fake()->text(),
            'category_id' => rand(1, $categoriesCount),
        ];
    }
}
