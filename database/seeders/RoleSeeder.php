<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Role\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'nom' => 'Administrateur'
            ],
            [
                'nom' => 'RH'
            ],
            [
                'nom' => 'Collaborateur'
            ],
        ];
        foreach($roles as $role){
            Role::create($role);
        }
    }
}
