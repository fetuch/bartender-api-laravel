<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Drink;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertDrinkRequest extends FormRequest
{
    public function getCategory(): Category
    {
        return Category::where('uuid', $this->data['attributes']['categoryId'])->firstOrFail();
    }

    public function rules()
    {
        return [
            'data' => [
                'required',
                'array:type,attributes',
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
        ];
    }
}
