<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PokemonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this['id'] ?? null,
            'name' => $this['name'] ?? null,
            'supertype' => $this['supertype'] ?? null,
            'subtypes' => $this['subtypes'] ?? [],
            'level' => $this['level'] ?? null,
            'hp' => $this['hp'] ?? null,
            'types' => $this['types'] ?? [],
            'evolvesFrom' => $this['evolvesFrom'] ?? null,
            'abilities' => $this['abilities'] ?? [],
            'attacks' => $this['attacks'] ?? [],
            'weaknesses' => $this['weaknesses'] ?? [],
            'resistances' => $this['resistances'] ?? [],
            'retreatCost' => $this['retreatCost'] ?? [],
            'convertedRetreatCost' => $this['convertedRetreatCost'] ?? null,
            'set' => $this['set'] ?? [],
            'number' => $this['number'] ?? null,
            'artist' => $this['artist'] ?? null,
            'rarity' => $this['rarity'] ?? null,
            'flavorText' => $this['flavorText'] ?? null,
            'nationalPokedexNumbers' => $this['nationalPokedexNumbers'] ?? [],
            'legalities' => $this['legalities'] ?? [],
            'images' => $this['images'] ?? [],
            'tcgplayer' => $this['tcgplayer'] ?? [],
            'cardmarket' => $this['cardmarket'] ?? [],
        ];
    }
}
