<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PokemonController;
use App\Http\Middleware\EnsureTokenIsValid;

/* Auth routes */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/* Card routes */

Route::middleware([EnsureTokenIsValid::class])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('/cards/search', [CardController::class, 'search']);
    Route::get('/cards/search/{type}', [CardController::class, 'searchByType']);
    Route::apiResource('/cards',CardController::class);
    Route::get('/pokemon', [PokemonController::class, 'index']);
});