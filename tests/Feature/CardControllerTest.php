<?php


namespace Tests\Feature;

use App\Models\Card;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PokemonCardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $defaultCardData;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        Passport::actingAs($user);
        $pokemonTcgData = [
            'image' => [
                'small' => 'https://images.pokemontcg.io/dp3/3.png',
                'large' => 'https://images.pokemontcg.io/dp3/3_hires.png'
            ],
            'types' => ['Normal'],
        ];

        $this->defaultCardData = [
            'name' => 'Charizard Diamond Pearl',
            'date_received' => '2023-06-01',
            'price' => 100.00,
            'condition' => 9,
            'pokemon_tcg_id' => 'dp3',
            'pokemon_tcg_data' => $pokemonTcgData,
            'pieces' => 2,
            'remarks' => 'Holo rare',
            'user_id' => $user->id,
        ];

        $this->user = $user;
    }


    public function test_create_card()
    {
        $response = $this->postJson('/api/cards', $this->defaultCardData);
        $response->assertStatus(201)
            ->assertJsonFragment($this->defaultCardData);
    }

    public function test_update_card(): void
    {

        $card = Card::factory()->create($this->defaultCardData);

        $newData = [
            'price' => 85.50,
            'condition' => 7,
        ];

        $updatedData = array_merge($card->toArray(), $newData);

        $response = $this->putJson("/api/cards/{$card->id}", $updatedData);
        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
    }

    public function test_delete_card(): void
    {
        $card = Card::factory()->create($this->defaultCardData);
        $response = $this->deleteJson("/api/cards/{$card->id}");
        $response->assertStatus(204);
    }

    public function test_view_card(): void
    {
        $card = Card::factory()->create($this->defaultCardData);
        $response = $this->getJson("/api/cards/{$card->id}");
        $response->assertStatus(200)
            ->assertJsonFragment([
                'name' => $card->name,
                'date_received' => $card->date_received,
                'price' => $card->price,
                'condition' => $card->condition,
                'remarks' => $card->remarks,
            ]);
    }

    public function test_view_cards_list(): void
    {
        Card::factory()->count(15)->create();
        $response = $this->getJson('/api/cards?page=1&pageSize=10');
        $response->assertStatus(200)
            ->assertJsonCount(10, 'data.data')
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data',
                    'total',
                    'page',
                    'pageSize'
                ]
            ]);
    }


    public function test_view_cards_list_sort(): void
    {
        Card::factory()->count(15)->create();
        $response = $this->getJson('/api/cards?page=1&pageSize=10');
        $response->assertStatus(200)
            ->assertJsonCount(10, 'data.data')
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data',
                    'total',
                    'page',
                    'pageSize'
                ]
            ]);
    }

    public function test_search(): void
    {
        $pokemonTcgData1 = [
            'image' => [
                'small' => 'https://images.pokemontcg.io/dp3/3.png',
                'large' => 'https://images.pokemontcg.io/dp3/3_hires.png'
            ],
            'types' => ['Lightning'],
            'tags' => ['rare', 'holo'],
            'price' => 120.00
        ];

        $pokemonTcgData2 = [
            'image' => [
                'small' => 'https://images.pokemontcg.io/dp3/4.png',
                'large' => 'https://images.pokemontcg.io/dp3/4_hires.png'
            ],
            'types' => ['Fire'],
            'tags' => ['common'],
            'price' => 60.00
        ];

        Card::create([
            'name' => 'Pikachu',
            'date_received' => '2023-07-01',
            'price' => 50.00,
            'condition' => 8,
            'pokemon_tcg_id' => 'dp1',
            'pieces' => 1,
            'remarks' => 'Electric rare',
            'pokemon_tcg_data' => $pokemonTcgData1,
            'user_id' =>  $this->user->id
        ]);

        Card::create([
            'name' => 'Charizard',
            'date_received' => '2023-06-01',
            'price' => 100.00,
            'condition' => 9,
            'pokemon_tcg_id' => 'dp3',
            'pieces' => 2,
            'remarks' => 'Holo rare',
            'pokemon_tcg_data' => $pokemonTcgData2,
            'user_id' =>  $this->user->id
        ]);

        $response = $this->getJson('/api/cards/search?tags[]=rare&price=120.00&page=1&pageSize=10');
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.data')
            ->assertJsonStructure([
                'success',
                'data' => [
                    'data',
                    'total',
                    'page',
                    'pageSize'
                ]
            ]);
    }
}
