<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Departement\Models\Departement;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departements = [
            [
                'nom' => 'Departement IT',
                'Description' => 'Departement de développement informatique'
            ],
            [
                'nom' => 'Departement RH',
                'Description' => 'Departement de ressource humaine'
            ],
        ];
        foreach ($departements as $departement) {
            Departement::create($departement);
        }
    }
}
