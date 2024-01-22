<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Parametrage\Models\JoursFeries;

class JoursFeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feriesFixes = [
            [
                'nom' => 'Nouvel an',
                'jour' => '01',
                'mois' => '01',
                'fixe' => true,
            ],
            [
                'nom' => 'Anniversaire de l\'Indépendance',
                'jour' => '11',
                'mois' => '01',
                'fixe' => true,
            ],
            [
                'nom' => 'Fête du Travail',
                'jour' => '01',
                'mois' => '05',
                'fixe' => true,
            ],
            [
                'nom' => 'Fête du Trône',
                'jour' => '30',
                'mois' => '07',
                'fixe' => true,
            ],
            [
                'nom' => 'Commémoration de l\'allégeance de l\'oued Eddahab',
                'jour' => '14',
                'mois' => '08',
                'fixe' => true,
            ],
            [
                'nom' => 'Anniversaire de la révolution, du roi et du peuple',
                'jour' => '20',
                'mois' => '08',
                'fixe' => true,
            ],
            [
                'nom' => 'Anniversaire du roi Mohammed VI',
                'jour' => '21',
                'mois' => '08',
                'fixe' => true,
            ],
            [
                'nom' => 'Anniversaire de la Marche verte',
                'jour' => '06',
                'mois' => '11',
                'fixe' => true,
            ],
            [
                'nom' => 'Fête de l\'Indépendance',
                'jour' => '18',
                'mois' => '11',
                'fixe' => true,
            ],
        ];
        foreach ($feriesFixes as $ferie) {
            JoursFeries::create($ferie);
        }
    }
}
