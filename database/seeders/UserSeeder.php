<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'role_id' => 1,
                'email' => 'admin@admin.com',
                'password' => '123456',
            ]
        ];

        foreach ($users as $user) {
            $user = User::create($user);
        }
    }
}
