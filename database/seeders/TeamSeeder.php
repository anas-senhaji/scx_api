<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Team\Models\Team;
use App\Modules\Tournament\Models\Tournament;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            [
                'name' => 'GLADIATORS'
            ],
            [
                'name' => 'GLADIATORS 1'
            ],
            [
                'name' => 'GLADIATORS 2'
            ],
            [
                'name' => 'GLADIATORS 3'
            ],
        ];
        $i = 1;
        foreach($teams as $team){
            $createdTeam = Team::create($team);
            $createdTeam->players()->attach([$i, $i+1]);
            // $tournament = Tournament::find(1);
            // $tournament->teams()->attach($createdTeam);
            $i+2;
        }
    }
}
