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

    public function getIngredients(): Collection
    {
        if (isset($this->data['relationships']['ingredients']['data'])) {
            $uuids = Arr::pluck($this->data['relationships']['ingredients']['data'], 'id');
            return Ingredient::whereIn('uuid', $uuids)->get();
        }

        return Collection::make([]);
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
