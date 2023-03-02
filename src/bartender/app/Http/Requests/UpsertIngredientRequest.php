<?php

namespace App\Http\Requests;

use App\Models\Ingredient;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertIngredientRequest extends FormRequest
{
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
                Rule::in(Ingredient::$resourceType)
            ],

            'data.attributes' => [
                'required',
                'array',
            ],

            'data.attributes.name' => [
                'required',
                'string',
                Rule::unique('ingredients', 'name')->ignore($this->ingredient),
            ],
            'data.attributes.description' => [
                'nullable',
                'sometimes',
                'string',
            ],
        ];
    }
}
