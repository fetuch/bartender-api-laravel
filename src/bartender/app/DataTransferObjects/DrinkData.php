<?php

namespace App\DataTransferObjects;

use App\Http\Requests\UpsertDrinkRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class DrinkData
{
    public function __construct(
        public readonly Category $category,
        public readonly array $ingredients,
        public readonly string $name,
        public readonly string $instructions
    ) {
    }

    public static function fromRequest(UpsertDrinkRequest $request): self
    {
        return new static(
            $request->getCategory(),
            $request->getIngredients(),
            $request->data['attributes']['name'],
            $request->data['attributes']['instructions'],
        );
    }
}
