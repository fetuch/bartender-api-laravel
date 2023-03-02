<?php

namespace App\DataTransferObjects;

use App\Http\Requests\UpsertDrinkRequest;
use App\Models\Category;

class DrinkData
{
    public function __construct(
        public readonly Category $category,
        public readonly string $name,
        public readonly string $instructions
    ) {
    }

    public static function fromRequest(UpsertDrinkRequest $request): self
    {
        return new static(
            $request->getCategory(),
            $request->data['attributes']['name'],
            $request->data['attributes']['instructions'],
        );
    }
}
