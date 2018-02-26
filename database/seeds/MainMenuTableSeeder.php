<?php

use Illuminate\Database\Seeder;

class MainMenuTableSeeder extends Seeder
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
                'title' => 'What',
                'title_ru' => 'Что',
                'title_lv' => 'Kas',
                'parent' => null,
                'description' => 'Container for Dishes',
                'description_ru' => 'Пункт меню, в котором будут выводиться блюда',
            ],
            [
                'title' => 'Who',
                'title_ru' => 'Кто',
                'title_lv' => 'Kurš',
                'parent' => null,
                'description' => 'Container for Team and History',
                'description_ru' => 'Список сотрудников и историй',
            ],
            [
                'title' => 'Where',
                'title_ru' => 'Где',
                'title_lv' => 'Kur',
                'parent' => null,
                'description' => 'Container for Places',
                'description_ru' => 'Список мест',
                'image' => 'img/fixtures/main_menu/where.jpg'
            ],
            [
                'title' => 'Wine list',
                'title_ru' => 'Винная карта',
                'title_lv' => 'Vīnu karte',
                'name' => 'wine',
                'parent' => null,
                'description' => 'Container for Wine groups',
                'description_ru' => 'Список категорий вин',
                'image' => 'img/fixtures/main_menu/wine.jpg',
            ],
            [
                'title' => 'Events',
                'title_ru' => 'Мероприятия',
                'title_lv' => 'Pasākumi',
                'parent' => null,
                'description' => 'Container for Events',
                'description_ru' => 'Список мероприятий',
                'image' => 'img/fixtures/main_menu/events.jpg',
            ],
            [
                'title' => 'Contacts',
                'title_ru' => 'Контакты',
                'title_lv' => 'Kontakti',
                'parent' => null,
                'description' => 'Contacts page',
                'description_ru' => 'Страница контактов',
                'image' => 'img/fixtures/main_menu/contacts.jpg',
            ],
            [
                'title' => 'Menu',
                'title_ru' => 'Меню',
                'title_lv' => 'Ēdienkarte',
                'parent' => null,
                'description' => 'Container for Menu groups',
                'description_ru' => 'Список категорий меню',
                'image' => 'img/fixtures/main_menu/menu.jpg',
            ],
        ];
        $this->insertData($data);
        $data = [
            [
                'title' => 'History',
                'title_ru' => 'История',
                'title_lv' => 'Ēdienkarte',
                'parent' => \App\MainMenu::whereTitle('Who')->first()->id,
                'description' => 'Histories list',
                'description_ru' => 'Список категорий меню',
                'image' => 'img/fixtures/main_menu/histories.jpg',
                'order' => 0,
            ],
            [
                'title' => 'Team',
                'title_ru' => 'Команда',
                'title_lv' => 'Ēdienkarte',
                'parent' => \App\MainMenu::whereTitle('Who')->first()->id,
                'description' => 'Teammates list',
                'description_ru' => 'Список категорий меню',
                'image' => 'img/fixtures/main_menu/teammates.jpg',
                'order' => 1,
            ],
            [
                'title' => 'Dishes',
                'title_ru' => 'Блюда',
                'title_lv' => 'Ēdienkarte',
                'description' => 'Dishes list',
                'description_ru' => 'Список категорий меню',
                'parent' => \App\MainMenu::whereTitle('What')->first()->id,
                'image' => 'img/fixtures/main_menu/dishes.jpg',
                'order' => 0,
            ],
        ];
        $this->insertData($data);


    }

    private function insertData(array $data)
    {
        foreach ($data as $index => $item) {
            \App\MainMenu::create([
                'title' => $item['title'],
                'title_ru' => $item['title_ru'] ?? '',
                'title_lv' => $item['title_lv'] ?? '',
                'name' => $item['name'] ?? null,
                'parent' => $item['parent'],
                'description' => $item['description'],
                'description_ru' => $item['description_ru'] ?? '',
                'description_lv' => $item['description_lv'] ?? '',
                'order' => $item['order'] ?? $index,
                'image' => $item['image'] ?? null,
                'disabled' => false,
            ]);
        }
    }
}
