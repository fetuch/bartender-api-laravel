<?php

use App\Models\Category;
use App\Models\Drink;
use App\Models\Ingredient;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;

it('should update a drink')
    ->tap(function () {
        $ingredients = Ingredient::factory()->count(3)->create();

        $category = Category::factory([
            'name' => 'Shot',
        ])->create();

        $drink = Drink::factory([
            'name' => 'Test name',
            'instructions' => 'Test instructions',
            'category_id' => $category,
        ])->create();

        $data = [
            'data' => [
                'type' => Drink::$resourceType,
                'attributes' => [
                    'name' => 'Margarita',
                    'instructions' => 'Drink instructions',
                    'categoryId' => $category->uuid,
                ],
                'relationships' => [
                    'ingredients' => [
                        'data' => [
                            [
                                'type' => Ingredient::$resourceType,
                                'id' => $ingredients[1]->uuid,
                            ],
                            [
                                'type' => Ingredient::$resourceType,
                                'id' => $ingredients[2]->uuid,
                            ],
                        ],
                    ],
                ],
            ]
        ];

        putJson(route('drinks.update', compact('drink')), $data)->assertStatus(Response::HTTP_NO_CONTENT);

        $drink = getJson(route('drinks.show', compact('drink')))
            ->json('data');

        expect($drink)
            ->attributes->name->toBe('Margarita')
            ->attributes->instructions->toBe('Drink instructions');
    })
    ->assertDatabaseMissing('drink_ingredient', ['drink_id' => 1, 'ingredient_id' => 1])
    ->assertDatabaseHas('drink_ingredient', ['drink_id' => 1, 'ingredient_id' => 2])
    ->assertDatabaseHas('drink_ingredient', ['drink_id' => 1, 'ingredient_id' => 3])
    ->group('drink', 'update-drink');
