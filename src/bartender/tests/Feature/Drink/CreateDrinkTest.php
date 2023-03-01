<?php

use App\Models\Category;

use function Pest\Laravel\postJson;

it('should create a drink', function () {
    $drink = postJson(route('drinks.store'), [
        'categoryId' => Category::factory()->create()->uuid,

        'name' => 'Margarita',
        'instructions' => 'Drink instructions',
    ])->json('data');

    expect($drink)
        ->attributes->name->toBe('Margarita')
        ->attributes->instructions->toBe('Drink instructions');
})->group('drink', 'create-drink');

it('should return 422 if name is invalid', function (?string $name) {
    postJson(route('drinks.store'), [
        'name' => $name,
        'instructions' => 'instructions',
        'categoryId' => Category::factory()->create()->uuid,
    ])->assertInvalid(['name']);
})->with([
    null,
    '',
])->group('drink', 'create-drink');

it('should return 422 if instructions are invalid', function (?string $instructions) {
    postJson(route('drinks.store'), [
        'instructions' => $instructions,
        'name' => 'Drink name',
        'categoryId' => Category::factory()->create()->uuid,
    ])->assertInvalid(['instructions']);
})->with([
    null,
    '',
])->group('drink', 'create-drink');

it('should return 422 if category is invalid', function (?string $categoryID) {
    postJson(route('drinks.store'), [
        'categoryID' => $categoryID,
        'instructions' => 'instructions',
        'name' => 'drink name',
    ])->assertInvalid(['categoryId']);
})->with([
    'invalid-category-id',
    null,
    '',
])->group('drink', 'create-drink');
