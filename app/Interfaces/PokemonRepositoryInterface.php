<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface PokemonRepositoryInterface
{
    public function getPokemons(array $queryParams);
}
