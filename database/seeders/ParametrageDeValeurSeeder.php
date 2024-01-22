<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\eTypeParametrageDeValeur;
use App\Modules\Parametrage\Models\ParametrageDeValeur;

class ParametrageDeValeurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parametrages = [
            [
                'nom' => eTypeParametrageDeValeur::_JOURS_AVANT_DEMANDE_CONGE,
                'minimum' => '15',
                'maximum' => '15',
            ],
            [
                'nom' => eTypeParametrageDeValeur::_JOURS_AJOUTES_PAR_MOIS,
                'minimum' => '1.5',
                'maximum' => '1.5',
            ],
            [
                'nom' => eTypeParametrageDeValeur::_HEURES_TRAVAILLEES_PAR_JOUR,
                'minimum' => '8',
                'maximum' => '8',
            ],
        ];
        foreach ($parametrages as $parametrage) {
            ParametrageDeValeur::create($parametrage);
        }
    }
}
