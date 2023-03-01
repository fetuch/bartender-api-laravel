<?php

use App\Models\Ingredient;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\getJson;

it('should return 404 if an ingredient not found', function () {
    getJson(route('ingredients.show', ['ingredient' => 'not-exists']))
        ->assertStatus(Response::HTTP_NOT_FOUND);
})->group('ingredient', 'get-ingredient');

it('should return an ingredient', function () {
    $ingredient = Ingredient::factory([
        'name' => 'Gin',
        'description' => 'Gin description',
    ])->create();

    $ingredientResponse = getJson(route('ingredients.show', compact('ingredient')))
        ->json('data');

    expect($ingredientResponse)
        ->id->toBe($ingredient->uuid)
        ->attributes->name->toBe('Gin')
        ->attributes->description->toBe('Gin description');
})->group('ingredient', 'get-ingredient');

it('should return all ingredients', function () {
    Ingredient::factory()
        ->sequence(
            ['name' => 'Gin', 'description' => 'Gin description'],
            ['name' => 'Vodka', 'description' => ''],
        )
        ->count(2)
        ->create();

    $ingredientsResponse = getJson(route('ingredients.index'))
        ->json('data');

    expect($ingredientsResponse)->sequence(
        fn ($ingredient) => $ingredient->attributes->name->toBe('Gin'),
        fn ($ingredient) => $ingredient->attributes->name->toBe('Vodka'),
    );
})->group('ingredient', 'get-ingredient');
