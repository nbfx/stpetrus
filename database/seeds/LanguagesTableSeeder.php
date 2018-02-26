<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
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
                'title' => 'Русский',
                'locale' => 'ru',
                'description' => 'Русский язык',
                'order' => 0,
            ],
            [
                'title' => 'Latviešu',
                'locale' => 'lv',
                'description' => 'Latvijas',
                'order' => 1,
            ],
        ];

        foreach ($data as $item) {
            \App\Language::create($item);
        }
    }
}
