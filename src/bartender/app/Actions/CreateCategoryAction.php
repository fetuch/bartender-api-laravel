<?php
namespace App\Actions;

use App\DataTransferObjects\CategoryData;
use App\Models\Category;

class CreateCategoryAction
{
    public function execute(CategoryData $categoryData): Category
    {
        return Category::create([
            'name' => $categoryData->name,
            'description' => $categoryData->description,
        ]);
    }
}
