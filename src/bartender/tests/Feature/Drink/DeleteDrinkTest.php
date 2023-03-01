<?php

use App\Models\Drink;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;

it('should delete a drink', function () {
    $drink = Drink::factory()->create();

    deleteJson(route('drinks.destroy', compact('drink')))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    getJson(route('drinks.show', compact('drink')))
        ->assertStatus(Response::HTTP_NOT_FOUND);
})->group('drink', 'delete-drink');
