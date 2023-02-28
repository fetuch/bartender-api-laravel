<?php

namespace App\Http\Controllers;

use App\Http\Resources\DrinkResource;
use App\Models\Drink;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;


class DrinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drinks =  QueryBuilder::for(Drink::class)
            ->defaultSort('name')
            ->allowedIncludes(['category'])
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
    public function store(Request $request): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): Response
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        //
    }
}
