<?php

namespace App\Http\Controllers;

use App\Actions\UpsertDrinkAction;
use App\DataTransferObjects\DrinkData;
use App\Http\Requests\UpsertDrinkRequest;
use App\Http\Resources\DrinkResource;
use App\Models\Drink;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;


class DrinkController extends Controller
{
    public function __construct(
        private readonly UpsertDrinkAction $upsertDrink,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drinks =  QueryBuilder::for(Drink::class)
            ->defaultSort('name')
            ->allowedIncludes(['category'])
            ->allowedFilters(['category.name'])
            ->jsonPaginate();

        return DrinkResource::collection($drinks);
    }

    /**
     * Display the specified resource.
     */
    public function show(Drink $drink): DrinkResource
    {
        return DrinkResource::make($drink);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpsertDrinkRequest $request): JsonResponse
    {
        return DrinkResource::make($this->upsert($request, new Drink()))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpsertDrinkRequest $request, Drink $drink): HttpResponse
    {
        $drink = $this->upsert($request, $drink);
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        //
    }

    private function upsert(UpsertDrinkRequest $request, Drink $drink): Drink
    {
        $drinkData = DrinkData::fromRequest($request);

        return $this->upsertDrink->execute($drink, $drinkData);
    }
}
