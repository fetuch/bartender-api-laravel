<?php

use App\Models\Category;
use App\Models\Drink;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\getJson;

it('should return 404 if a drink not found', function () {
    getJson(route('drinks.show', ['drink' => 'not-exists']))
        ->assertStatus(Response::HTTP_NOT_FOUND);
})->group('drink', 'get-drink');

it('should return a drink', function () {
    $drink = Drink::factory([
        'name' => 'Margarita',
        'instructions' => 'Margarita instructions',
    ])->create();

    $drinkResponse = getJson(route('drinks.show', compact('drink')))
        ->json('data');

    expect($drinkResponse)
        ->id->toBe($drink->uuid)
        ->attributes->name->toBe('Margarita')
        ->attributes->instructions->toBe('Margarita instructions');
})->group('drink', 'get-drink');

it('should return all drinks', function () {
    Drink::factory()->count(5)->create();

    $drinks = getJson(route('drinks.index'))
        ->json('data');

    expect($drinks)->toHaveCount(5);
})->group('drink', 'get-drink');

it('should filter drinks by category name', function () {
    Drink::factory()->count(4)->create();

    $shot = Category::factory(['name' => 'Shot'])->create();

    $shotDrinks = Drink::factory([
        'category_id' => $shot,
    ])->count(2)->create();

    $drinks = getJson(
        route('drinks.index', [
            'filter' => [
                'category.name' => 'shot',
            ]
        ]))
        ->json('data');

    expect($drinks)->toHaveCount(2);
    expect($drinks)->each(fn ($drink) => $drink->id->toBeIn($shotDrinks->pluck('uuid')));
})->group('drink', 'get-drink');

