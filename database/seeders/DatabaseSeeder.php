<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\GroupeSeeder;
use Database\Seeders\TypeCongeSeeder;
use Database\Seeders\JoursFeriesSeeder;
use Database\Seeders\JoursTravailSeeder;
use Database\Seeders\WorkflowValidationSeeder;
use Database\Seeders\ParametrageDeValeurSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(WorkflowValidationSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GroupeSeeder::class);
        $this->call(DepartementSeeder::class);
        $this->call(CollaborateurSeeder::class);
        $this->call(JoursFeriesSeeder::class);
        $this->call(JoursTravailSeeder::class);
        $this->call(TypeCongeSeeder::class);
        $this->call(ParametrageDeValeurSeeder::class);
    }
}
