<?php

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

