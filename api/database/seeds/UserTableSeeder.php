<?php

use Illuminate\Database\Seeder;
use App\Entities\User;

class UserTableSeeder extends Seeder
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
                "name" => "adm",
                "password" => User::encryptPassword("pass"),
                "is_adm" => 1,
            ]
        ];

        foreach ($users as $account) {
            User::create($account);
        }
    }
}
