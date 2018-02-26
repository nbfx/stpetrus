<?php

use Illuminate\Database\Seeder;

class TeammatesTableSeeder extends Seeder
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
                'f_name' => 'Maksim',
                'l_name' => 'Cekot',
                'position' => 'Chef',
                'text' => '"The pursuit of excellence!" - Maksims Cekots, Executive Chef of St. Petrus Restaurant. Our Executive chef, Maksims Cekots, believes that being a professional chef is a vocation and not just a job. He brings a wealth of international experience to the kitchen after working in Michelin Star restaurants in Great Britain, France and Spain. His main vision is to offer fresh and enjoyable dining experiences to guests by offering creative and unforgettable dishes that immerse the diners into a world of culinary pleasures! The St. Petrus Restaurant offers a unique and innovative dining experience that is to be savored and enjoyed by all our guests.',
                'description' => '',
                'image' => 'img/teammates/1-fixture.png',
                'order' => 0,
            ],
            [
                'f_name' => 'Dmitri',
                'l_name' => 'Fedosevich',
                'position' => 'Su-chef',
                'text' => '"Don\'t forget your roots; be humble. Don\'t be afraid to try new things; stay fresh." - Dmitri Fedosevich Graduated "London Kingsway College", Hospitality and Culinary Arts program. Had extensive experience working at a Michelin-starred restaurant in London. Enjoys the cooking process and the result of completed work. Aims to fulfill one of his dreams – to develop an audio cooking book for blind people. In addition, Dmitri wants to host an culinary programs of international cuisine, traveling and exploring the world. Dmitri is currently working at the St.Petrus restaurant to create a new trend in Latvian culinary, taking into account the well-established traditions for centuries of Baltic history.',
                'description' => '',
                'image' => 'img/teammates/2-fixture.png',
                'order' => 1,
            ],
            [
                'f_name' => 'Karina',
                'l_name' => 'Leladze',
                'position' => 'Owner',
                'text' => 'The owner of restaurant St. Petrus, Karina Leladze is of Georgian descent with cordial and generous hospitality skills: I have always dreamt to start my own restaurant, where I can host a larger group of my friends and other guests as warmly as at home. While working in the financial sector industry, I had a greater interest of tourism and hospitality industry and realised that I belong here".',
                'description' => '',
                'image' => 'img/teammates/3-fixture.png',
                'order' => 2,
            ],
            [
                'f_name' => 'Karina',
                'l_name' => 'Popova',
                'position' => 'Director of Marketing and PR',
                'text' => '"Participation in International Marketing Project management and strategic planning of tourism and hospitality, coupled with quality control projects for 5 star hotel group across Europe, Middle East and Russia gave me an invaluable experience, knowledge and deep understanding of what needs our guests restaurants are." - Karina Popova, Director of Marketing and PR of St. Petrus Restaurant.',
                'description' => '',
                'image' => 'img/teammates/4-fixture.png',
                'order' => 3,
            ],
        ];

        foreach ($data as $item) {
            \App\Teammate::insert($item);
        }
    }
}
