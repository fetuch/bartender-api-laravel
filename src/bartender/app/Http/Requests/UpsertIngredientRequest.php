<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertIngredientRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                Rule::unique('ingredients', 'name')->ignore($this->ingredient),
            ],
            'description' => [
                'nullable',
                'sometimes',
                'string',
            ],
        ];
    }
}
