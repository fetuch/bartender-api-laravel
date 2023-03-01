<?php

namespace App\Actions;

use App\DataTransferObjects\IngredientData;
use App\Models\Ingredient;

class UpsertIngredientAction
{
    public function execute(Ingredient $ingredient, IngredientData $ingredientData): Ingredient
    {
        $ingredient->name = $ingredientData->name;
        $ingredient->description = $ingredientData->description;
        $ingredient->save();

        return $ingredient;
    }
}
