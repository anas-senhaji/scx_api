<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Modules\Organizer\Models\Organizer;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizer = Organizer::create([
            'name' => 'Eagles',
            'birth_date' => '2012-01-01',
            'country_id' => 115,
        ]);

        $user = User::create([
            'email' => 'eagles@gmail.com',
            'password' => '123456', // It's important to hash passwords
        ]);
        $user->userable()->associate($organizer);
        $user->save();
    }
}
