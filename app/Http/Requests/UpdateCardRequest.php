<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCardRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'date_received' => 'sometimes|required|date',
            'price' => 'sometimes|required|numeric|min:0',
            'condition' => 'sometimes|required|integer|min:1|max:10',
            'pokemon_tcg_id' => 'nullable|string|max:255',
            'pokemon_tcg_data' => 'nullable|array',
            'pieces' => 'sometimes|required|numeric',
            'remarks' => 'nullable|string|max:255',
        ];
    }
}
