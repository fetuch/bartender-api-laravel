<?php

namespace App\DataTransferObjects;

class CategoryData
{
    public function __construct(public readonly string $name, public readonly ?string $description)
    {
    }
}
