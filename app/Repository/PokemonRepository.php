<?php

namespace App\Repository;

use App\Interfaces\PokemonRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonRepository implements PokemonRepositoryInterface
{
    public function getPokemons(array $queryParams)
    {
        $response = Http::withHeaders([
            'x-api-key' => env('POKEMON_API_KEY'),
        ])->get('https://api.pokemontcg.io/v2/cards', $queryParams);

        return $response->json();
    }
}
