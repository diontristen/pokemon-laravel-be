<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:64',
            'date_received' => 'required|date',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|integer|min:1|max:10',
            'pokemon_tcg_id' => 'nullable|string|max:255',
            'pokemon_tcg_data' => 'nullable|array',
            'pieces' => 'required|integer',
            'remarks' => 'nullable|string|max:255',
        ];
    }
}
