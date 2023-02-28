<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use TiMacDonald\JsonApi\Link;

class CategoryResource extends JsonApiResource
{
    public function toId(Request $request): string
    {
        return $this->uuid;
    }

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
            Link::self(route('categories.show', ['category' => $this->uuid]))
        ];
    }
}
