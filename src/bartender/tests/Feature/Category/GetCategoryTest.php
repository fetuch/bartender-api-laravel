<?php

use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\getJson;

it('should return 404 if a category not found', function () {
    getJson(route('categories.show', ['category' => 'not-exists']))
        ->assertStatus(Response::HTTP_NOT_FOUND);
})->group('category', 'get-category');

it('should return a category', function () {
    $category = Category::factory([
        'name' => 'Shot',
        'description' => 'Shot description',
    ])->create();

    $categoryResponse = getJson(route('categories.show', compact('category')))
        ->json('data');

    expect($categoryResponse)
        ->id->toBe($category->uuid)
        ->attributes->name->toBe('Shot')
        ->attributes->description->toBe('Shot description');
})->group('category', 'get-category');

it('should return all categories', function () {
    Category::factory()
        ->sequence(
            ['name' => 'Shot', 'description' => 'Shot description'],
            ['name' => 'Shake', 'description' => ''],
        )
        ->count(2)
        ->create();

    $categoriesResponse = getJson(route('categories.index'))
        ->json('data');

    expect($categoriesResponse)->sequence(
        fn ($category) => $category->attributes->name->toBe('Shot'),
        fn ($category) => $category->attributes->name->toBe('Shake'),
    );
})->group('category', 'get-category');
