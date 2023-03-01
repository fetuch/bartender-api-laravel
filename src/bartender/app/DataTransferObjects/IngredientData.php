<?php

namespace App\DataTransferObjects;

class IngredientData
{
    public function __construct(public readonly string $name, public readonly ?string $description)
    {
    }
}
