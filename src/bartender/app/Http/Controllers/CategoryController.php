<?php

namespace App\Http\Controllers;

use App\Actions\CreateCategoryAction;
use App\Actions\UpdateCategoryAction;
use App\DataTransferObjects\CategoryData;
use App\Http\Requests\UpsertCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CreateCategoryAction $createCategory,
        private readonly UpdateCategoryAction $updateCategory,
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpsertCategoryRequest $request)
    {
        $categoryData = new CategoryData(...$request->validated());
        $category = $this->createCategory->execute($categoryData);

        return CategoryResource::make($category)
            ->response();
            // ->status(Response::HTTP_CREATED);

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpsertCategoryRequest $request, Category $category)
    {
        $categoryData = new CategoryData(...$request->validated());
        $category = $this->updateCategory->execute($category, $categoryData);

        return response()->noContent();
    }
}
