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
                'name'           => 'Naveed Shahzad',
                'email'          => 'lhrciit@gmail.com',
                'api_token' => str_random(60),
                'password' => Hash::make('12345678')
            ],
        ];
        User::insert($users);
    }
}
