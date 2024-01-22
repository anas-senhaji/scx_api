<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Groupe\Models\Groupe;

class GroupeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groupes = [
            [
                'nom' => 'Devcorp',
                'description' => 'Software groupe',
            ],
            [
                'nom' => 'Nextronic',
                'description' => 'Hardware groupe',
            ],
        ];

        foreach($groupes as $groupe) {
            Groupe::create($groupe);
        }
    }
}
