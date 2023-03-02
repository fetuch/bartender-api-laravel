<?php

use App\Models\Ingredient;

use function Pest\Laravel\putJson;

it('should update an ingredient', function (string $name, string $description) {
    $ingredient = Ingredient::factory(['name' => 'Gin'])->create();

    $data = [
        'data' => [
            'type' => Ingredient::$resourceType,
            'attributes' => [
                'name' => $name,
                'description' => $description,
            ],
        ]
    ];

    putJson(route('ingredients.update', compact('ingredient')), $data)->assertNoContent();

    expect(Ingredient::find($ingredient->id))
        ->name->toBe($name)
        ->description->toBe($description);
})
    ->with([
        ['name' => 'Gin', 'description' => 'Updated Description'],
        ['name' => 'Vodka', 'description' => 'Updated Description'],
    ])->group('ingredient', 'update-ingredient');;
