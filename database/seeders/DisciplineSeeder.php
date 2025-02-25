<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Discipline\Models\Discipline;

class DisciplineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $disciplines = [
            [
                'name' => 'WEPF'
            ],
            [
                'name' => 'WPA'
            ],
            [
                'name' => 'INTERNATIONAL RULES'
            ],
        ];
        foreach($disciplines as $discipline){
            Discipline::create($discipline);
        }
    }
}
