<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

//Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/', function () {
    return redirect('admin');
});
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::get('/', 'MainMenuController@list')->name('admin');

    /* main menu */
    Route::get('main-menu-list', 'MainMenuController@list')->name('main_menu_list');
    Route::get('main-menu-add', 'MainMenuController@add')->name('main_menu_add');
    Route::get('main-menu-edit/{id}', 'MainMenuController@edit')->name('main_menu_edit');
    Route::post('main-menu-validate', 'MainMenuController@validateFields')->name('main_menu_validate');
    Route::post('main-menu-save', 'MainMenuController@save')->name('main_menu_save');
    Route::post('main-menu-swap', 'MainMenuController@swap')->name('main_menu_swap');
    Route::post('main-menu-toggleDisabled', 'MainMenuController@toggleDisabled')->name('main_menu_toggleDisabled');
    Route::post('main-menu-remove', 'MainMenuController@remove')->name('main_menu_remove');

    /* languages */
    Route::get('languages-list', 'LanguageController@list')->name('languages_list');
    Route::get('languages-add', 'LanguageController@add')->name('languages_add');
    Route::get('languages-edit/{id}', 'LanguageController@edit')->name('languages_edit');
    Route::post('languages-validate', 'LanguageController@validateFields')->name('languages_validate');
    Route::post('languages-save', 'LanguageController@save')->name('languages_save');
    Route::post('languages-swap', 'LanguageController@swap')->name('languages_swap');
    Route::post('languages-toggleDisabled', 'LanguageController@toggleDisabled')->name('languages_toggleDisabled');
    Route::post('languages-remove', 'LanguageController@remove')->name('languages_remove');

    /* dishes */
    Route::get('dishes-list', 'DishController@list')->name('dishes_list');
    Route::get('dishes-add', 'DishController@add')->name('dishes_add');
    Route::get('dishes-edit/{id}', 'DishController@edit')->name('dishes_edit');
    Route::post('dishes-save', 'DishController@save')->name('dishes_save');
    Route::post('dishes-validate', 'DishController@validateFields')->name('dishes_validate');
    Route::post('dishes-swap', 'DishController@swap')->name('dishes_swap');
    Route::post('dishes-toggleDisabled', 'DishController@toggleDisabled')->name('dishes_toggleDisabled');
    Route::post('dishes-remove', 'DishController@remove')->name('dishes_remove');

    /* teammates */
    Route::get('teammates-list', 'TeammateController@list')->name('teammates_list');
    Route::get('teammates-add', 'TeammateController@add')->name('teammates_add');
    Route::get('teammates-edit/{id}', 'TeammateController@edit')->name('teammates_edit');
    Route::post('teammates-validate', 'TeammateController@validateFields')->name('teammates_validate');
    Route::post('teammates-save', 'TeammateController@save')->name('teammates_save');
    Route::post('teammates-swap', 'TeammateController@swap')->name('teammates_swap');
    Route::post('teammates-toggleDisabled', 'TeammateController@toggleDisabled')->name('teammates_toggleDisabled');
    Route::post('teammates-remove', 'TeammateController@remove')->name('teammates_remove');

    /* histories */
    Route::get('histories-list', 'HistoryController@list')->name('histories_list');
    Route::get('histories-add', 'HistoryController@add')->name('histories_add');
    Route::get('histories-edit/{id}', 'HistoryController@edit')->name('histories_edit');
    Route::post('histories-validate', 'HistoryController@validateFields')->name('histories_validate');
    Route::post('histories-save', 'HistoryController@save')->name('histories_save');
    Route::post('histories-swap', 'HistoryController@swap')->name('histories_swap');
    Route::post('histories-toggleDisabled', 'HistoryController@toggleDisabled')->name('histories_toggleDisabled');
    Route::post('histories-remove', 'HistoryController@remove')->name('histories_remove');

    /* places */
    Route::get('places-list', 'PlaceController@list')->name('places_list');
    Route::get('places-add', 'PlaceController@add')->name('places_add');
    Route::get('places-edit/{id}', 'PlaceController@edit')->name('places_edit');
    Route::post('places-validate', 'PlaceController@validateFields')->name('places_validate');
    Route::post('places-save', 'PlaceController@save')->name('places_save');
    Route::post('places-swap', 'PlaceController@swap')->name('places_swap');
    Route::post('places-toggleDisabled', 'PlaceController@toggleDisabled')->name('places_toggleDisabled');
    Route::post('places-remove', 'PlaceController@remove')->name('places_remove');

    /* menu */
    Route::get('menu-groups', 'MenuGroupController@list')->name('menu_groups_list');
    Route::get('menu-groups-add', 'MenuGroupController@add')->name('menu_groups_add');
    Route::get('menu-groups-edit/{id}', 'MenuGroupController@edit')->name('menu_groups_edit');
    Route::post('menu-groups-validate', 'MenuGroupController@validateFields')->name('menu_groups_validate');
    Route::post('menu-groups-save', 'MenuGroupController@save')->name('menu_groups_save');
    Route::post('menu-groups-swap', 'MenuGroupController@swap')->name('menu_groups_swap');
    Route::post('menu-groups-toggleDisabled', 'MenuGroupController@toggleDisabled')->name('menu_groups_toggleDisabled');
    Route::post('menu-groups-remove', 'MenuGroupController@remove')->name('menu_groups_remove');

    Route::get('menu-items', 'MenuItemController@list')->name('menu_items_list');
    Route::get('menu-items-add', 'MenuItemController@add')->name('menu_items_add');
    Route::get('menu-items-edit/{id}', 'MenuItemController@edit')->name('menu_items_edit');
    Route::post('menu-items-validate', 'MenuItemController@validateFields')->name('menu_items_validate');
    Route::post('menu-items-save', 'MenuItemController@save')->name('menu_items_save');
    Route::post('menu-items-swap', 'MenuItemController@swap')->name('menu_items_swap');
    Route::post('menu-items-toggleDisabled', 'MenuItemController@toggleDisabled')->name('menu_items_toggleDisabled');
    Route::post('menu-items-remove', 'MenuItemController@remove')->name('menu_items_remove');

    /* wines */
    Route::get('wine-groups', 'WineGroupController@list')->name('wine_groups_list');
    Route::get('wine-groups-add', 'WineGroupController@add')->name('wine_groups_add');
    Route::get('wine-groups-edit/{id}', 'WineGroupController@edit')->name('wine_groups_edit');
    Route::post('wine-groups-validate', 'WineGroupController@validateFields')->name('wine_groups_validate');
    Route::post('wine-groups-save', 'WineGroupController@save')->name('wine_groups_save');
    Route::post('wine-groups-swap', 'WineGroupController@swap')->name('wine_groups_swap');
    Route::post('wine-groups-toggleDisabled', 'WineGroupController@toggleDisabled')->name('wine_groups_toggleDisabled');
    Route::post('wine-groups-remove', 'WineGroupController@remove')->name('wine_groups_remove');

    Route::get('wine-items', 'WineItemController@list')->name('wine_items_list');
    Route::get('wine-items-add', 'WineItemController@add')->name('wine_items_add');
    Route::get('wine-items-edit/{id}', 'WineItemController@edit')->name('wine_items_edit');
    Route::post('wine-items-validate', 'WineItemController@validateFields')->name('wine_items_validate');
    Route::post('wine-items-save', 'WineItemController@save')->name('wine_items_save');
    Route::post('wine-items-swap', 'WineItemController@swap')->name('wine_items_swap');
    Route::post('wine-items-toggleDisabled', 'WineItemController@toggleDisabled')->name('wine_items_toggleDisabled');
    Route::post('wine-items-remove', 'WineItemController@remove')->name('wine_items_remove');

    /* drinks */
    Route::get('drinks', 'DrinkController@list')->name('drinks_list');
    Route::get('drinks-add', 'DrinkController@add')->name('drinks_add');
    Route::get('drinks-edit/{id}', 'DrinkController@edit')->name('drinks_edit');
    Route::post('drinks-validate', 'DrinkController@validateFields')->name('drinks_validate');
    Route::post('drinks-save', 'DrinkController@save')->name('drinks_save');
    Route::post('drinks-swap', 'DrinkController@swap')->name('drinks_swap');
    Route::post('drinks-toggleDisabled', 'DrinkController@toggleDisabled')->name('drinks_toggleDisabled');
    Route::post('drinks-remove', 'DrinkController@remove')->name('drinks_remove');

    Route::get('drink-groups', 'DrinkGroupController@list')->name('drink_groups_list');
    Route::get('drink-groups-add', 'DrinkGroupController@add')->name('drink_groups_add');
    Route::get('drink-groups-edit/{id}', 'DrinkGroupController@edit')->name('drink_groups_edit');
    Route::post('drink-groups-validate', 'DrinkGroupController@validateFields')->name('drink_groups_validate');
    Route::post('drink-groups-save', 'DrinkGroupController@save')->name('drink_groups_save');
    Route::post('drink-groups-swap', 'DrinkGroupController@swap')->name('drink_groups_swap');
    Route::post('drink-groups-toggleDisabled', 'DrinkGroupController@toggleDisabled')->name('drink_groups_toggleDisabled');
    Route::post('drink-groups-remove', 'DrinkGroupController@remove')->name('drink_groups_remove');

    Route::get('drink-items', 'DrinkItemController@list')->name('drink_items_list');
    Route::get('drink-items-add', 'DrinkItemController@add')->name('drink_items_add');
    Route::get('drink-items-edit/{id}', 'DrinkItemController@edit')->name('drink_items_edit');
    Route::post('drink-items-validate', 'DrinkItemController@validateFields')->name('drink_items_validate');
    Route::post('drink-items-save', 'DrinkItemController@save')->name('drink_items_save');
    Route::post('drink-items-swap', 'DrinkItemController@swap')->name('drink_items_swap');
    Route::post('drink-items-toggleDisabled', 'DrinkItemController@toggleDisabled')->name('drink_items_toggleDisabled');
    Route::post('drink-items-remove', 'DrinkItemController@remove')->name('drink_items_remove');

    /* meta */
    Route::get('meta', 'MetaController@list')->name('meta_list');
    Route::get('meta-add', 'MetaController@add')->name('meta_add');
    Route::get('meta-edit/{id}', 'MetaController@edit')->name('meta_edit');
    Route::post('meta-save', 'MetaController@save')->name('meta_save');
    Route::post('meta-remove', 'MetaController@remove')->name('meta_remove');
    Route::post('meta-swap', 'MetaController@swap')->name('meta_swap');
    Route::post('meta-toggleDisabled', 'MetaController@toggleDisabled')->name('meta_toggleDisabled');
    Route::post('meta-validate', 'MetaController@validateFields')->name('meta_validate');

    /* events */
    Route::get('events', 'EventController@list')->name('events_list');
    Route::get('events-add', 'EventController@add')->name('events_add');
    Route::get('events-edit/{id}', 'EventController@edit')->name('events_edit');
    Route::post('events-validate', 'EventController@validateFields')->name('events_validate');
    Route::post('events-save', 'EventController@save')->name('events_save');
    Route::post('events-swap', 'EventController@swap')->name('events_swap');
    Route::post('events-toggleDisabled', 'EventController@toggleDisabled')->name('events_toggleDisabled');
    Route::post('events-remove', 'EventController@remove')->name('events_remove');

    /* contacts */
    Route::get('contacts-edit', 'ContactController@edit')->name('contacts_edit');
    Route::post('contacts-save', 'ContactController@save')->name('contacts_save');
    Route::post('contacts-validate', 'ContactController@validateFields')->name('contacts_validate');

    /* social */
    Route::get('social', 'SocialController@list')->name('social_list');
    Route::get('social-add', 'SocialController@add')->name('social_add');
    Route::post('social-swap', 'SocialController@swap')->name('social_swap');
    Route::post('social-remove', 'SocialController@remove')->name('social_remove');
    Route::post('social-toggleDisabled', 'SocialController@toggleDisabled')->name('social_toggleDisabled');
    Route::post('social-save', 'SocialController@save')->name('social_save');
    Route::post('social-validate', 'SocialController@validateFields')->name('social_validate');
    Route::get('social-edit/{id}', 'SocialController@edit')->name('social_edit');

    /* slider */
    Route::get('slider-edit', 'SliderController@edit')->name('slider_edit');
    Route::post('slider-save', 'SliderController@save')->name('slider_save');
    Route::post('slider-validate', 'SliderController@validateFields')->name('slider_validate');

    Route::get('slides-add', 'SlideController@add')->name('slides_add');
    Route::post('slides-save', 'SlideController@save')->name('slides_save');
    Route::post('slides-swap', 'SlideController@swap')->name('slides_swap');
    Route::post('slides-validate', 'SlideController@validateFields')->name('slides_validate');
    Route::post('slides-toggleDisabled', 'SlideController@toggleDisabled')->name('slides_toggleDisabled');
    Route::post('slides-remove', 'SlideController@remove')->name('slides_remove');

    /* images */
    Route::get('images/{directory?}', 'ImageController@list')->name('images_list');
    Route::post('images-remove', 'ImageController@remove')->name('images_remove');

    Route::get('{url?}', 'AdminController@notFound')->name('adminNotFound');
});

Route::group(['middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ], 'prefix' => LaravelLocalization::setLocale()], function() {
    /** LOCALIZED ROUTES **/
    Route::get('/', 'SiteController@index')->name('index');
    Route::get('/teammates', 'SiteController@teammates')->name('teammates');
    Route::get('/histories', 'SiteController@histories')->name('histories');
    Route::get('/what', 'SiteController@what')->name('what');
    Route::get('/who', 'SiteController@who')->name('who');
    Route::get('/where', 'SiteController@where')->name('where');
    Route::get('/events', 'SiteController@events')->name('events');
    Route::get('/contacts', 'SiteController@contacts')->name('contacts');
    Route::get('/wine', 'SiteController@wine')->name('wine');
    Route::get('/drinks', 'SiteController@drinks')->name('drinks');
    Route::get('/wine/{group?}', 'SiteController@wineGroup')->name('wineGroup');
    Route::get('/spirit', 'SiteController@spirit')->name('spirit');
    Route::get('/spirit/{group?}', 'SiteController@spiritGroup')->name('spiritGroup');
    Route::get('/cocktail', 'SiteController@cocktail')->name('cocktail');
    Route::get('/cocktail/{group?}', 'SiteController@cocktailGroup')->name('cocktailGroup');
    Route::get('/menu', 'SiteController@menu')->name('menu');
    Route::get('/menu/{group?}', 'SiteController@menuGroup')->name('menuGroup');
    Route::get('/{url?}', 'SiteController@notFound')->where(['url' => '^(?!admin).*$'])->name('notFound');
    Route::get('/admin', 'MainMenuController@list')->name('admin')->middleware('auth');
});
