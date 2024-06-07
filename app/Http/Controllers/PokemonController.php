<?php

namespace App\Http\Controllers;
use App\Classes\ApiResponseClass;

use App\Http\Requests\PokemonRequest;
use App\Http\Resources\PokemonResource;
use App\Interfaces\PokemonRepositoryInterface;

class PokemonController extends Controller
{
    protected $pokemonRepository;

    public function __construct(PokemonRepositoryInterface $pokemonRepository)
    {
        $this->pokemonRepository = $pokemonRepository;
    }

    public function index(PokemonRequest $request)
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);

        $sortBy = $request->input('sortBy', []);
        $sortOrder = $request->input('sortOrder', []);
        $filters = $request->except(['page', 'pageSize', 'sortBy', 'sortOrder']);

        if (!is_array($sortBy)) {
            $sortBy = [$sortBy];
        }
        if (!is_array($sortOrder)) {
            $sortOrder = [$sortOrder];
        }

        $translatedOrderBy = array_map(function ($field, $order) {
            return $order === 'desc' ? '-' . $field : $field;
        }, $sortBy, $sortOrder);

        $queryParams = [
            'page' => $page,
            'pageSize' => $pageSize,
        ];

        if (!empty($translatedOrderBy)) {
            $queryParams['orderBy'] = implode(',', $translatedOrderBy);
        }

        if (isset($filters['name'])) {
            $queryParams['q'] = 'name:' . $filters['name'] . '*';
        }
        $data = $this->pokemonRepository->getPokemons($queryParams);

        return ApiResponseClass::sendResponse([
            'data' => PokemonResource::collection(collect($data['data'])),
            'page' => $data['page'],
            'pageSize' => $data['pageSize'],
            'count' => count($data['data']),
            'total' => $data['totalCount'],
        ], 'Retrieve pokemon cards');
       
    }
}
