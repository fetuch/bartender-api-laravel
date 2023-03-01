<?php

use App\Models\Category;
use App\Models\Drink;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;

it('should update a drink', function () {
    $category = Category::factory([
        'name' => 'Shot',
    ])->create();

    $drink = Drink::factory([
        'name' => 'Test name',
        'instructions' => 'Test instructions',
        'category_id' => $category,
    ])->create();

    putJson(route('drinks.update', ['drink' => $drink]), [
        'name' => 'Margarita',
        'instructions' => 'Drink instructions',
        'categoryId' => $category->uuid,
    ])->assertStatus(Response::HTTP_NO_CONTENT);

    $drink = getJson(route('drinks.show', compact('drink')))
        ->json('data');

    expect($drink)
        ->attributes->name->toBe('Margarita')
        ->attributes->instructions->toBe('Drink instructions');
})->group('drink', 'update-drink');
