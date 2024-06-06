<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PokemonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'page' => 'nullable|integer|min:1',
            'pageSize' => 'nullable|integer|min:1|max:100',
            'sortBy' => 'nullable|array',
            'sortBy.*' => 'string',
            'sortOrder' => 'nullable|array',
            'sortOrder.*' => 'in:asc,desc',
            'name' => 'nullable|string',
        ];
    }
}
