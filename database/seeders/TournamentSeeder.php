<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Player\Models\Player;
use App\Modules\Tournament\Models\Tournament;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tournaments = [
            [
                'name' => 'HRS OPEN AMATEUR',
                'start_date' => '2024-02-14',
                'end_date' => '2024-02-15',
                'place' => 'Casablanca',
                'info' => 'The format for this event will be Single Elimination (2 Session Matches) Last 128 to Last 16 will be Best of 25 Frames Last 16 to Semi Final will be Best of 27 Final will be Best of 29 Frames',
                'ranking_points' => [
                    'winner' => 6000,
                    'last-2' => 3000,
                    'last-4' => 2000,
                    'last-8' => 1500,
                    'last-16' => 1250,
                    'last-32' => 1000,
                    'last-64' => 500,
                    'last-128' => 250,
                ],
                'prize_money' => [
                    'winner' => 10000,
                    'last-2' => 40000,
                    'last-4' => 1600,
                    'last-8' => 700,
                    'last-16' => 500,
                ],
                'tournament_type_id' =>  1,
                'event_id' => 1,
                'organizer_id' => 1,
            ],
            [
                'name' => 'HRS OPEN DEBUTANS PLUS',
                'start_date' => '2024-02-17',
                'end_date' => '2024-02-18',
                'place' => 'Rabat',
                'info' => 'The format for this event will be Single Elimination (2 Session Matches) Last 128 to Last 16 will be Best of 25 Frames Last 16 to Semi Final will be Best of 27 Final will be Best of 29 Frames',
                'ranking_points' => [
                    'winner' => 6000,
                    'last-2' => 3000,
                    'last-4' => 2000,
                    'last-8' => 1500,
                    'last-16' => 1250,
                    'last-32' => 1000,
                    'last-64' => 500,
                    'last-128' => 250,
                ],
                'prize_money' => [
                    'winner' => 10000,
                    'last-2' => 40000,
                    'last-4' => 1600,
                    'last-8' => 700,
                    'last-16' => 500,
                ],
                'tournament_type_id' =>  1,
                'country_id' => 151,
                'discipline_id' => 3,
                'organizer_id' => 1,
            ],
        ];
        foreach($tournaments as $tournament){
            $tournament = Tournament::create($tournament);
            $players = Player::take(128)->get();
            foreach ($players as $player) {
                // Assign the tournament's players
                $tournament->players()->detach([$player->id]);
                $tournament->players()->attach([$player->id]);
            }
        }

    }
}
