<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertCategoryRequest extends FormRequest
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
                Rule::in(Category::$resourceType)
            ],

            'data.attributes' => [
                'required',
                'array',
            ],

            'data.attributes.name' => [
                'required',
                'string',
                Rule::unique('categories', 'name')->ignore($this->category),
            ],
            'data.attributes.description' => [
                'nullable',
                'sometimes',
                'string',
            ],
        ];
    }
}
