<?php

use App\Models\Category;

use function Pest\Laravel\putJson;

it('should update a category', function (string $name, string $description) {
    $category = Category::factory(['name' => 'Shake'])->create();

    $data = [
        'data' => [
            'type' => Category::$resourceType,
            'attributes' => [
                'name' => $name,
                'description' => $description,
            ],
        ]
    ];

    putJson(route('categories.update', compact('category')), $data)->assertNoContent();

    expect(Category::find($category->id))
        ->name->toBe($name)
        ->description->toBe($description);
})
    ->with([
        ['name' => 'Shake', 'description' => 'Updated Description'],
        ['name' => 'Shot', 'description' => 'Updated Description'],
    ])->group('category', 'update-category');
