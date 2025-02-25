<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Modules\Player\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'birth_date' => $this->faker->date(),
            'gender' => 'man', // since you want all players to be 'man'
            'country_id' => 115,
            'nickname' => $this->faker->userName,
        ];
    }
}

