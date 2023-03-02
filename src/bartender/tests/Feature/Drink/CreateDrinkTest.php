<?php

use App\Models\Category;
use App\Models\Drink;

use function Pest\Laravel\postJson;

it('should create a drink', function () {
    $data = [
        'data' => [
            'type' => Drink::$resourceType,
            'attributes' => [
                'categoryId' => Category::factory()->create()->uuid,
                'name' => 'Margarita',
                'instructions' => 'Drink instructions',
            ],
        ]
    ];

    $drink = postJson(route('drinks.store'), $data)->json('data');

    expect($drink)
        ->attributes->name->toBe('Margarita')
        ->attributes->instructions->toBe('Drink instructions');
})->group('drink', 'create-drink');

it('should return 422 if name is invalid', function (?string $name) {
    $data = [
        'data' => [
            'type' => Drink::$resourceType,
            'attributes' => [
                'categoryId' => Category::factory()->create()->uuid,
                'name' => $name,
                'instructions' => 'Drink instructions',
            ],
        ]
    ];

    postJson(route('drinks.store'), $data)->assertInvalid(['data.attributes.name']);
})->with([
    null,
    '',
])->group('drink', 'create-drink');

it('should return 422 if instructions are invalid', function (?string $instructions) {
    $data = [
        'data' => [
            'type' => Drink::$resourceType,
            'attributes' => [
                'categoryId' => Category::factory()->create()->uuid,
                'name' => 'Margarita',
                'instructions' => $instructions,
            ],
        ]
    ];

    postJson(route('drinks.store'), $data)->assertInvalid(['data.attributes.instructions']);
})->with([
    null,
    '',
])->group('drink', 'create-drink');

it('should return 422 if category is invalid', function (?string $categoryID) {
    $data = [
        'data' => [
            'type' => Drink::$resourceType,
            'attributes' => [
                'categoryId' => $categoryID,
                'name' => 'Margarita',
                'instructions' => 'Drink instructions',
            ],
        ]
    ];

    postJson(route('drinks.store'), $data)->assertInvalid(['data.attributes.categoryId']);
})->with([
    'invalid-category-id',
    null,
    '',
])->group('drink', 'create-drink');
