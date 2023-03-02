<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use TiMacDonald\JsonApi\Link;

class DrinkResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'instructions' => $this->instructions,
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'category' => fn () => new CategoryResource($this->category),
        ];
    }

    public function toLinks(Request $request): array
    {
        return [
            Link::self(route('drinks.show', ['drink' => $this->uuid]))
        ];
    }
}
