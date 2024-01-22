<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Parametrage\Models\TypeConge;

class TypeCongeSeeder extends Seeder
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
                'nom' => 'Annuel',
                'couleur' => '#2bb12b'
            ],
            [
                'nom' => 'Maladie',
                'couleur' => '#9b63ab'
            ],
            [
                'nom' => 'Mariage',
                'couleur' => '#fa6f87'
            ],
            [
                'nom' => 'Maternité/Paternité',
                'couleur' => '#000000'
            ],
            [
                'nom' => 'Décès',
                'couleur' => '#008080'
            ],
        ];
        foreach ($types as $type) {
            TypeConge::create($type);
        }
    }
}
