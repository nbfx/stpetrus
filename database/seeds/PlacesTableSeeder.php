<?php

use Illuminate\Database\Seeder;

class PlacesTableSeeder extends Seeder
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
                'title' => 'Open the doors',
                'text' => 'The symbolism of our restaurant is the key... The key to the door that will open to you a world of gastronomic art and history of modern Baltic cuisine, combined with Scandinavian trends and an interesting range of wines.',
                'description' => '',
                'image' => 'img/places/1-fixture.png',
                'order' => 0,
            ],
            [
                'title' => '"St. Petrus"',
                'text' => 'In this gorgeous setting we find restaurant "St.Petrus" on Skārņu Street 11',
                'description' => '',
                'image' => 'img/places/2-fixture.png',
                'order' => 1,
            ],
            [
                'title' => 'Heart of Riga',
                'text' => 'In the heart of Riga\'s Old Town… at the foot of St. Peter\'s Church… there is an elegant, modern building pictorially fitting and enhancing the streets of old city.',
                'description' => '',
                'image' => 'img/places/3-fixture.png',
                'order' => 2,
            ],
            [
                'title' => '1-st floor',
                'text' => 'The first floor, reflects a lively gastropub environment with an undivided kitchen that enables guests to view and experience the energy of the restaurant. This style enables guests to dine in comfort and enjoy day-to-day chats and events where the chef and his team share their creative seasonal Baltic cooking.',
                'description' => '',
                'image' => 'img/places/4-fixture.png',
                'order' => 3,
            ],
            [
                'title' => '2-nd floor',
                'text' => 'On the second floor, a classic restaurant offers of more exquisite and romantic atmosphere with a picturesque view on the Saint Peter’s Church, making it an ideal setting for special occasions.',
                'description' => '',
                'image' => 'img/places/5-fixture.png',
                'order' => 4,
            ],
            [
                'title' => 'Wine',
                'text' => 'Our sommelier expertly selects wines not only from established vineyards of the Old and New World, but also emphasising Eastern European wines.',
                'description' => '',
                'image' => 'img/places/6-fixture.png',
                'order' => 5,
            ],
        ];

        foreach ($data as $item) {
            \App\Place::insert($item);
        }
    }
}
