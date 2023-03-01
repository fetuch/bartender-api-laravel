<?php

use function Pest\Laravel\postJson;

it('should create an ingredient', function () {
    $ingredient = postJson(route('ingredients.store'), [
        'name' => 'Gin',
        'description' => 'Gin description',
    ])->json('data');

    expect($ingredient)
        ->attributes->name->toBe('Gin')
        ->attributes->description->toBe('Gin description');
})->group('ingredient', 'create-ingredient');

it('should return 422 if name is invalid', function (?string $name) {
    postJson(route('ingredients.store'), [
        'name' => $name,
    ])->assertInvalid(['name']);
})->with([
    null,
    '',
])->group('ingredient', 'create-ingredient');
