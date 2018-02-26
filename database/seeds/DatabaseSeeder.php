<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguagesTableSeeder::class);
        $this->call(MainMenuTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(HistoriesTableSeeder::class);
        $this->call(TeammatesTableSeeder::class);
        $this->call(PlacesTableSeeder::class);
    }
}
