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

