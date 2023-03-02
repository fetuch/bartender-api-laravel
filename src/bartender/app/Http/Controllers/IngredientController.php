<?php

namespace App\Http\Controllers;

use App\Actions\UpsertIngredientAction;
use App\DataTransferObjects\IngredientData;
use App\Http\Requests\UpsertIngredientRequest;
use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class IngredientController extends Controller
{
    public function __construct(
        private readonly UpsertIngredientAction $upsertIngredient,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return IngredientResource::collection(Ingredient::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $Ingredient): IngredientResource
    {
        return IngredientResource::make($Ingredient);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpsertIngredientRequest $request): JsonResponse
    {
        return IngredientResource::make($this->upsert($request, new Ingredient()))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpsertIngredientRequest $request, Ingredient $Ingredient): HttpResponse
    {
        $this->upsert($request, $Ingredient);
        return response()->noContent();
    }

    private function upsert(UpsertIngredientRequest $request, Ingredient $Ingredient): Ingredient
    {
        $IngredientData = new IngredientData(...($request->data['attributes']));
        return $this->upsertIngredient->execute($Ingredient, $IngredientData);
    }
}
