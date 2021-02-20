<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
                'id'             => 1,
                'name'           => 'Administration',
                'email'          => 'admin@admin.com',
                'api_token' => str_random(60),
                'password' => Hash::make('password')
            ],
        ];
        User::insert($users);
    }
}
