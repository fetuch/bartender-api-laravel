<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Drink;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class UpsertDrinkRequest extends FormRequest
{
    public function getCategory(): Category
    {
        return Category::where('uuid', $this->data['attributes']['categoryId'])->firstOrFail();
    }

    public function getIngredients(): array
    {

        if (isset($this->data['relationships']['ingredients']['data'])) {
            $ingredientsData = Collection::make($this->data['relationships']['ingredients']['data']);
            $uuids = $ingredientsData->pluck('id');
            $ingredients = Ingredient::whereIn('uuid', $uuids)->select('id', 'uuid')->get();

            $arr = [];
            foreach ($ingredients as $ingredient) {
                $ingredientData = $ingredientsData->first(function ($ingredientData) use ($ingredient) {
                    return $ingredientData['id'] === $ingredient->uuid;
                });

                if (isset($ingredientData['meta']['pivot']['measure'])) {
                    $arr[$ingredient->id] = ['measure' => $ingredientData['meta']['pivot']['measure']];
                } else {
                    $arr[] = $ingredient->id;
                }
            }

            return $arr;
        }

        return [];
    }

    public function rules()
    {
        return [
            'data' => [
                'required',
                'array',
            ],

            'data.type' => [
                'required',
                'string',
                Rule::in(Drink::$resourceType)
            ],

            'data.attributes' => [
                'required',
                'array',
            ],

            'data.attributes.name' => [
                'required',
                'string',
            ],
            'data.attributes.instructions' => [
                'required',
                'string',
            ],

            'data.attributes.categoryId' => [
                'required',
                'string',
                'exists:categories,uuid'
            ],

            'data.relationships' => [
                'sometimes',
                'array',
            ],

            'data.relationships.ingredients' => [
                'sometimes',
                'array',
            ],

            'data.relationships.ingredients.data' => [
                'array',
            ],

            'data.relationships.ingredients.data.*.type' => [
                'required',
                'string',
                Rule::in(Ingredient::$resourceType)
            ],

            'data.relationships.ingredients.data.*.id' => [
                'required',
                'string',
                'exists:ingredients,uuid'
            ],

            'data.relationships.ingredients.data.*.meta.pivot.measure' => [
                'sometimes',
                'string',
            ],
        ];
    }
}
