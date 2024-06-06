<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\Card;
use App\Interfaces\CardRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Http\Resources\CardResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    private CardRepositoryInterface $cardRepositoryInterface;

    public function __construct(CardRepositoryInterface $cardRepositoryInterface)
    {
        $this->cardRepositoryInterface = $cardRepositoryInterface;
    }


    protected function buildQuery(Request $request): Builder
    {
        $query = Card::query();

        $user = Auth::guard('api')->user();
        $query->where('user_id', $user->id);

        if ($request->filled('name')) {
            $query->whereRaw('LOWER(name) ILIKE ?', ['%' . strtolower($request->name) . '%']);
        }

        if ($request->filled('tags')) {
            $tags = $request->tags;
            foreach ($tags as $tag) {
                $query->whereRaw('pokemon_tcg_data->\'tags\' @> ?', [json_encode([$tag])]);
            }
        }

        if ($request->filled('types')) {
            $types = $request->types;
            $typeConditions = array_map(function($type) {
                return "pokemon_tcg_data->'types' @> '".json_encode([$type])."'";
            }, $types);
            $query->whereRaw('(' . implode(' OR ', $typeConditions) . ')');
        }


        if ($request->filled('price')) {
            $query->whereRaw('CAST(pokemon_tcg_data->>\'price\' AS NUMERIC) = ?', [$request->price]);
        }

        return $query;
    }

    protected function applySorting(Builder $query, array $sortBy, array $sortOrder): Builder
    {
        foreach ($sortBy as $index => $field) {
            $order = $sortOrder[$index] ?? 'asc';
            if (in_array($field, ['price'])) {
                $query->orderByRaw('CAST(price AS NUMERIC) ' . $order);
            } else {
                $query->orderBy($field, $order);
            }
        }

        return $query;
    }

    protected function paginateResults(Builder $query, int $page, int $pageSize): LengthAwarePaginator
    {
        return $query->paginate($pageSize, ['*'], 'page', $page);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $pageSize = $request->get('pageSize', 10);
        $sortBy = $request->get('sortBy', []);
        $sortOrder = $request->get('sortOrder', []);

        $query = Card::query();
        $query = $this->buildQuery($request);

        $query = $this->applySorting($query, $sortBy, $sortOrder);

        $cards = $this->paginateResults($query, $page, $pageSize);

        return ApiResponseClass::sendResponse([
            'data' => CardResource::collection($cards->items()),
            'total' => $cards->total(),
            'page' => $cards->currentPage(),
            'pageSize' => $cards->perPage(),
        ], 'Cards retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCardRequest $request)
    {
        $user = Auth::guard('api')->user();
        $details = [
            'name' => $request->name,
            'date_received' => $request->date_received,
            'price' => $request->price,
            'condition' => $request->condition,
            'pokemon_tcg_id' => $request->pokemon_tcg_id,
            'pokemon_tcg_data' => $request->pokemon_tcg_data,
            'pieces' => $request->pieces,
            'remarks' => $request->remarks,
            'user_id' => $user->id
        ];
        DB::beginTransaction();
        try {
            $card = $this->cardRepositoryInterface->store($details);

            DB::commit();
            return ApiResponseClass::sendResponse(new CardResource($card), 'Card Create Successful', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $card = $this->cardRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new CardResource($card), 'Card has been added to your collection', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCardRequest $request, $id)
    {
        $user = Auth::guard('api')->user();

        $updateDetails = [
            'name' => $request->name,
            'date_received' => $request->date_received,
            'price' => $request->price,
            'condition' => $request->condition,
            'pokemon_tcg_id' => $request->pokemon_tcg_id,
            'pokemon_tcg_data' => $request->pokemon_tcg_data,
            'pieces' => $request->pieces,
            'remarks' => $request->remarks,
            'user_id' => $user->id
        ];
        DB::beginTransaction();
        try {
            $card = $this->cardRepositoryInterface->update($updateDetails, $id);
            DB::commit();
            return ApiResponseClass::sendResponse(new CardResource($card), 'Card has been updated successfully', 200);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->cardRepositoryInterface->delete($id);

        return ApiResponseClass::sendResponse('Card Delete Successful', '', 204);
    }

    public function search(Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $pageSize = $request->get('pageSize', 10);
        $sortBy = $request->get('sortBy', []);
        $sortOrder = $request->get('sortOrder', []);
        $query = $this->buildQuery($request);
        $query = $this->applySorting($query, $sortBy, $sortOrder);

        $cards = $this->paginateResults($query, $page, $pageSize);

        return ApiResponseClass::sendResponse([
            'data' => CardResource::collection($cards->items()),
            'total' => $cards->total(),
            'page' => $cards->currentPage(),
            'pageSize' => $cards->perPage(),
        ], 'Cards filtered successfully');
    }
}
