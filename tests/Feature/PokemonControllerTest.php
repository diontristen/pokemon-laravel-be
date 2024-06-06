<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PokemonControllerTest  extends TestCase
{
    use RefreshDatabase;

    public function test_pokemon_route(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->getJson('/api/pokemon?page=1&pageSize=10&sortBy[]=name&sortOrder[]=asc&sortBy[]=number&sortOrder[]=desc&name=Pikachu');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                    'success',
                    'data' => [
                        'data',
                        'totalCount',
                        'page',
                        'pageSize'
                    ]
                 ]);
    }
}
