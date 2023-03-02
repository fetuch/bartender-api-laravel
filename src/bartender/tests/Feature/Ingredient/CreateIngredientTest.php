<?php

use App\Models\Ingredient;

use function Pest\Laravel\postJson;

it('should create an ingredient', function () {
    $data = [
        'data' => [
            'type' => Ingredient::$resourceType,
            'attributes' => [
                'name' => 'Gin',
                'description' => 'Gin description',
            ],
        ]
    ];

    $ingredient = postJson(route('ingredients.store'), $data)->json('data');

    expect($ingredient)
        ->attributes->name->toBe('Gin')
        ->attributes->description->toBe('Gin description');
})->group('ingredient', 'create-ingredient');

it('should return 422 if name is invalid', function (?string $name) {
    $data = [
        'data' => [
            'type' => Ingredient::$resourceType,
            'attributes' => [
                'name' => $name,
                'description' => 'Gin description',
            ],
        ]
    ];

    postJson(route('ingredients.store'), $data)->assertInvalid(['data.attributes.name']);
})->with([
    null,
    '',
])->group('ingredient', 'create-ingredient');
