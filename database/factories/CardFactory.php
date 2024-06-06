<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'date_received' => $this->faker->date,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'condition' => $this->faker->numberBetween(1, 10),
            'pokemon_tcg_id' => $this->faker->randomNumber,
            'user_id' => User::factory(),
            'pieces' => $this->faker->numberBetween(1, 10),
            'remarks' => $this->faker->sentence,
            'pokemon_tcg_data' => [
                'image' => [
                    'small' => $this->faker->imageUrl,
                    'large' => $this->faker->imageUrl
                ],
                'types' => [$this->faker->word],
                'tags' => [$this->faker->word, $this->faker->word],
                'price' => $this->faker->randomFloat(2, 1, 100)
            ]
        ];
    }
}