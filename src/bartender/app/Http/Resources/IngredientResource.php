<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use TiMacDonald\JsonApi\Link;

class IngredientResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function toLinks(Request $request): array
    {
        return [
            Link::self(route('ingredients.show', ['ingredient' => $this->uuid]))
        ];
    }
}
