<?php

namespace App\Http\Controllers;

use App\Actions\UpsertCategoryAction;
use App\DataTransferObjects\CategoryData;
use App\Http\Requests\UpsertCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function __construct(
        private readonly UpsertCategoryAction $upsertCategory,
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpsertCategoryRequest $request): JsonResponse
    {
        return CategoryResource::make($this->upsert($request, new Category()))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpsertCategoryRequest $request, Category $category): HttpResponse
    {
        $this->upsert($request, $category);
        return response()->noContent();
    }

    private function upsert(UpsertCategoryRequest $request, Category $category): Category
    {
        $categoryData = new CategoryData(...$request->validated());
        return $this->upsertCategory->execute($category, $categoryData);
    }
}
