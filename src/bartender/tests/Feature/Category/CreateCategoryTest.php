<?php

use App\Models\Category;

use function Pest\Laravel\postJson;

it('should create a category', function () {
    $category = postJson(route('categories.store'), [
        'name' => 'Shot',
        'description' => 'Awesome drink category',
    ])->json('data');

    expect($category)
        ->attributes->name->toBe('Shot')
        ->attributes->description->toBe('Awesome drink category');
})->group('category', 'create-category');

it('should return 422 if name is invalid', function (?string $name) {
    Category::factory([
        'name' => 'Shot',
    ])->create();

    postJson(route('categories.store'), [
        'name' => $name,
        'description' => 'description',
    ])->assertInvalid(['name']);
})->with([
    '',
    null,
    'Shot'
])->group('category', 'create-category');
