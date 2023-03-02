<?php

use App\Models\Category;

use function Pest\Laravel\postJson;

it('should create a category', function () {
    $data = [
        'data' => [
            'type' => Category::$resourceType,
            'attributes' => [
                'name' => 'Shot',
                'description' => 'Awesome drink category',
            ],
        ]
    ];

    $category = postJson(route('categories.store'), $data)->json('data');

    expect($category)
        ->attributes->name->toBe('Shot')
        ->attributes->description->toBe('Awesome drink category');
})->group('category', 'create-category');

it('should return 422 if name is invalid', function (?string $name) {
    Category::factory([
        'name' => 'Shot',
    ])->create();

    $data = [
        'data' => [
            'type' => Category::$resourceType,
            'attributes' => [
                'name' => $name,
                'description' => 'Awesome drink category',
            ],
        ]
    ];

    postJson(route('categories.store'), $data)->assertInvalid(['data.attributes.name']);
})->with([
    '',
    null,
    'Shot'
])->group('category', 'create-category');
