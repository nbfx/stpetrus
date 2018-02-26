<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'stpetrus-admin',
                'email' => 'admin@stpetrus-restaurant.com',
                'role' => 'admin',
                'password' => bcrypt('passwd'),
            ],
        ];

        foreach ($data as $item) {
            \App\User::create($item);
        }
    }
}
