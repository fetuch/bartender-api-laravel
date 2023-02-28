<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpsertDrinkRequest extends FormRequest
{
    public function getCategory(): Category
    {
        return Category::where('uuid', $this->categoryId)->firstOrFail();
    }

    public function rules()
    {
        return [
            'categoryId' => ['required', 'string', 'exists:categories,uuid'],
            'name' => [
                'required',
                'string',
            ],
            'instructions' => [
                'required',
                'string',
            ],
        ];
    }
}
