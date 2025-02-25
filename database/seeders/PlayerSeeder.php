<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Modules\Player\Models\Player;
use Database\Factories\PlayerFactory;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        PlayerFactory::new()->count(128)->create();

        $players = Player::all();
        $i = 0;
        foreach ($players as $player) {
            $user = User::create([
                'email' => Str::slug($player->nickname, '-').$i.'@gmail.com',
                'password' => '123456', // It's important to hash passwords
            ]);
            $user->userable()->associate($player);
            $user->save();
            $i++;
        }
    }
}
