<?php
namespace App\Actions;

use App\DataTransferObjects\CategoryData;
use App\Models\Category;

class UpdateCategoryAction
{
    public function execute(Category $category, CategoryData $categoryData): Category
    {
        $category->name = $categoryData->name;
        $category->description = $categoryData->description;
        $category->save();

        return $category;
    }
}
