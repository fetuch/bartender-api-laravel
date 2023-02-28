<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;
use TiMacDonald\JsonApi\Link;

class DrinkResource extends JsonApiResource
{
    public function toId(Request $request): string
    {
        return $this->uuid;
    }

    public function toAttributes(Request $request): array
    {
        return [
            'name' => $this->name,
            'instructions' => $this->instructions,
        ];
    }

    public function toLinks(Request $request): array
    {
        return [
            Link::self(route('drinks.show', ['drink' => $this->uuid]))
        ];
    }
}
