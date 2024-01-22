<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Parametrage\Models\WorkflowValidation;

class WorkflowValidationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workflows = [
            [
                'type' => 'CONGE',
                'role_id' => null,
                'user_id' => null,
                'est_superviseur' => true,
                'niveau' => 1,
                'active' => true
            ],
            [
                'type' => 'CONGE',
                'role_id' => 2,
                'user_id' => null,
                'est_superviseur' => false,
                'niveau' => 2,
                'active' => true
            ],
        ];

        foreach($workflows as $workflow){
            WorkflowValidation::create($workflow);
        }
    }
}
