<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Parametrage\Models\JoursTravail;

class JoursTravailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jours = [
            [
                'jour' => 'Lundi',
                'est_travailleur' => true,
            ],
            [
                'jour' => 'Mardi',
                'est_travailleur' => true,
            ],
            [
                'jour' => 'Mercredi',
                'est_travailleur' => true,
            ],
            [
                'jour' => 'Jeudi',
                'est_travailleur' => true,
            ],
            [
                'jour' => 'Vendredi',
                'est_travailleur' => true,
            ],
            [
                'jour' => 'Samedi',
                'est_travailleur' => false,
            ],
            [
                'jour' => 'Dimanche',
                'est_travailleur' => false,
            ],
        ];

        foreach ($jours as $jour) {
            JoursTravail::create($jour);
        }
    }
}
