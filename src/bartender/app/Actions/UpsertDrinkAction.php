<?php
namespace App\Actions;

use App\DataTransferObjects\DrinkData;
use App\Models\Drink;

class UpsertDrinkAction
{
    public function execute(Drink $drink, DrinkData $drinkData): Drink
    {
        $drink->category_id = $drinkData->category->id;
        $drink->name = $drinkData->name;
        $drink->instructions = $drinkData->instructions;
        $drink->save();

        return $drink;
    }
}
