<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\CardRepositoryInterface;
use App\Repository\CardRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repository\UserRepository;
use App\Interfaces\PokemonRepositoryInterface;
use App\Repository\PokemonRepository;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CardRepositoryInterface::class,CardRepository::class);
        $this->app->bind(PokemonRepositoryInterface::class, PokemonRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
