<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Tournament\Models\TournamentType;

class TournamentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'INDIVIDUAL MAN',
                'gender' => 'man',
                'nbr_player' => '1',
            ],
            [
                'name' => 'INDIVIDUAL WOMAN',
                'gender' => 'woman',
                'nbr_player' => '1',
            ],
            [
                'name' => 'DOUBLET MAN',
                'gender' => 'man',
                'nbr_player' => '2',
            ],
            [
                'name' => 'DOUBLET WOMAN',
                'gender' => 'woman',
                'nbr_player' => '2',
            ],
            [
                'name' => 'DOUBLET MIXED',
                'gender' => 'mixte',
                'nbr_player' => '2',
            ],
        ];
        foreach($types as $type){
            TournamentType::create($type);
        }
    }
}
