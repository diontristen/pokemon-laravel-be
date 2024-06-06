<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date_received' => $this->date_received,
            'price' => $this->price,
            'condition' => $this->condition,
            'pieces' => $this->pieces,
            'pokemon_tcg_id' => $this->pokemon_tcg_id,
            'pokemon_tcg_data' => $this->pokemon_tcg_data,
            'user_id' => $this->user_id,
            'remarks' => $this->remarks,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
