<?php

namespace App\Http\Controllers;

use App\CocktailGroup;
use App\CocktailItem;
use App\Contact;
use App\Dish;
use App\Drink;
use App\DrinkGroup;
use App\DrinkItem;
use App\Event;
use App\Feedback;
use App\History;
use App\MainMenu;
use App\MenuGroup;
use App\MenuItem;
use App\Meta;
use App\Place;
use App\SpiritGroup;
use App\SpiritItem;
use App\Teammate;
use App\WineGroup;
use App\WineItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    const PREFIX = 'site';

    /** @var array */
    private $locales;

    /** @var string */
    private $currentLocale;

    private $translationSuffix;

    /** @var string */
    private $currentRoute;

    /** @var string */
    private $template;

    /** @var string */
    private $pageTitle;

    /** @var array */
    private $mainMenu;

    /** @var array */
    private $data = [];

    public function __construct()
    {
        $this->locales = LaravelLocalization::getSupportedLocales();
        $this->currentLocale = LaravelLocalization::getCurrentLocale();
        $this->translationSuffix = $this->currentLocale == config('app.fallback_locale') ? '' : "_$this->currentLocale";
        $this->currentRoute = request()->route() ? request()->route()->getName() : 'index';
        $this->mainMenu = $this->prepareMainMenu();
        $this->data = [
            'locales' => $this->locales,
            'currentLocale' => $this->currentLocale,
            'currentRoute' => $this->currentRoute,
            'pageTitle' => $this->pageTitle ?? trans('site.index.title'),
            'mainMenu' => $this->mainMenu,
            'activeMenu' => collect($this->mainMenu)->where('active', true)->first(),
            'metaTags' => $this->prepareMeta(),
        ];
    }

    /**
     * Get array of meta tags
     *
     * @return array
     */
    private function prepareMeta()
    {
        $allMeta = Meta::whereDisabled(false)->get();
        $result = [];
        foreach ($allMeta as $meta) {
            $result[] = [
                'name' => $meta->name,
                'content' => $meta->content,
            ];
        }

        return $result;
    }

    /**
     * @return array
     */
    private function prepareMainMenu()
    {
        foreach (MainMenu::getOnlyParents() as $item) {
            $mainMenu[] = [
                'name' => $item['name'],
                'title' => $item["title$this->translationSuffix"] ?? $item['title'],
                'image' => $item['image'],
                'children' => $this->getTranslated($item->getChildren($item->id)),
                'active' => $item['name'] == $this->currentRoute,
            ];
            if ($item['name'] == $this->currentRoute) $this->pageTitle = $item["title$this->translationSuffix"] ?? $item['title'];
        }

        return $mainMenu ?? [];
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * @param Collection $items
     * @return array
     */
    private function getTranslated($items = null)
    {
        if (!$items) return [];
        foreach ($items as $index => $item) {
            foreach ($item->toArray() as $field => $value) {
                if (in_array($field, $item->translatable)) {
                    if (isset($item[$field.$this->translationSuffix])) {
                        $translatedItem[$field] = $item[$field.$this->translationSuffix];
                    } else {
                        $translatedItem[$field] = $item[$field];
                    }
                } else {
                    $skip = false;
                    foreach ($this->locales as $locale => $properties) {
                        foreach ($item->translatable as $translatableField) {
                            if ($field == $translatableField.'_'.$locale) {
                                $skip = true;
                            }
                        }
                    }
                    if (!$skip) $translatedItem[$field] = $value;
                }
            }
            $translatedItems[] = $translatedItem ?? [];
        }

        return $translatedItems ?? [];
    }

    public function index()
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;

        return $this->draw();
    }

    public function what()
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $this->data['items'] = $this->getTranslated(Dish::orderBy('order')->get());

        return $this->draw();
    }

    public function who()
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $this->data['items'] = [
            'teammates' => $this->getTranslated(Teammate::orderBy('order')->get()),
            'histories' => $this->getTranslated(History::orderBy('order')->get()),
        ];

        return $this->draw();
    }

    public function where()
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $this->data['items'] = $this->getTranslated(Place::orderBy('order')->get());

        return $this->draw();
    }

    public function events()
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $this->data['items'] = $this->getTranslated(Event::orderBy('order')->get());

        return $this->draw();
    }

    public function contacts()
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $this->data['item'] = $this->getTranslated(Contact::first()->get())[0] ?? [];

        return $this->draw();
    }

    public function menu()
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $this->data['items'] = $this->getTranslated(MenuGroup::orderBy('order')->get());

        return $this->draw();
    }

    public function menuGroup($group)
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $group = $this->getTranslated(MenuGroup::whereName($group)->get());
        if (!$group) {
            return redirect(route('menu'));
        }
        $group = $group[0];
        $group['children'] = $this->getTranslated(MenuItem::where('parent', $group['id'])->orderBy('order')->get());
        $this->data['items'] = $group;
        $this->data['headerImage'] = MainMenu::whereName('menu')->first()->image;

        return $this->draw();
    }

    public function wine()
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $this->data['items'] = $this->getTranslated(WineGroup::orderBy('order')->get());

        return $this->draw();
    }

    public function wineGroup($group)
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $group = $this->getTranslated(WineGroup::whereName($group)->get());
        if (!$group) {
            return redirect(route('wine'));
        }
        $group = $group[0];
        $group['children'] = $this->getTranslated(WineItem::where('parent', $group['id'])->orderBy('order')->get());
        $this->data['items'] = $group;
        $this->data['headerImage'] = MainMenu::whereName('wine')->first()->image;

        return $this->draw();
    }

    /**
     * Drinks
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function drinks()
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $this->data['items'] = $this->getTranslated(Drink::orderBy('order')->get());

        return $this->draw();
    }

    public function drinkGroup($group)
    {
        $name = $group;
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $group = $this->getTranslated(Drink::whereName($group)->get());
        if (!$group) {
            return redirect(route('drinks'));
        }
        $group = $group[0];
        $group['children'] = $this->getTranslated(DrinkGroup::where('parent', $group['id'])->orderBy('order')->get());
        $this->data['items'] = $group;
        $this->data['headerImage'] = MainMenu::whereName('drinks')->first()->image;
        $this->data['group'] = $name;

        return $this->draw();
    }

    public function drinkSubgroup($group, $subgroup)
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $subgroup = $this->getTranslated(DrinkGroup::whereName($subgroup)->get());
        if (!$subgroup) {
            return redirect(route($group));
        }
        $subgroup = $subgroup[0];
        $subgroup['children'] = $this->getTranslated(DrinkItem::where('parent', $subgroup['id'])->orderBy('order')->get());
        $this->data['items'] = $subgroup;
        $this->data['headerImage'] = MainMenu::whereName('drinks')->first()->image;

        return $this->draw();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addFeedback(Request $request)
    {
        // TODO: add translations for response messages
        $data = $request->all();
        if (!empty($data['date_time'])) {
            $data['date_time'] = date('Y-m-d H:i:s', strtotime($data['date_time']));
        }
        $validator = Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'max:255',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255',
            'date_time' => 'date|after:today',
            'description' => 'max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages(), 'success' => false, 'message' => 'Please, fill in all required fields'], 200);
        }

        if (Feedback::create($data)) {
            return response()->json(['success' => true, 'message' => 'Feedback added!'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Internal error!'], 200);
        }
    }

    public function spirit()
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $this->data['items'] = $this->getTranslated(SpiritGroup::orderBy('order')->get());

        return $this->draw();
    }

    public function spiritGroup($group)
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $group = $this->getTranslated(SpiritGroup::whereName($group)->get());
        if (!$group) {
            return redirect(route('spirit'));
        }
        $group = $group[0];
        $group['children'] = $this->getTranslated(SpiritItem::where('parent', $group['id'])->orderBy('order')->get());
        $this->data['items'] = $group;
        $this->data['headerImage'] = MainMenu::whereName('spirit')->first()->image;

        return $this->draw();
    }

    public function cocktail()
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $this->data['items'] = $this->getTranslated(CocktailGroup::orderBy('order')->get());

        return $this->draw();
    }

    public function cocktailGroup($group)
    {
        $this->template = self::PREFIX . '.' . __FUNCTION__;
        $group = $this->getTranslated(CocktailGroup::whereName($group)->get());
        if (!$group) {
            return redirect(route('cocktail'));
        }
        $group = $group[0];
        $group['children'] = $this->getTranslated(CocktailItem::where('parent', $group['id'])->orderBy('order')->get());
        $this->data['items'] = $group;
        $this->data['headerImage'] = MainMenu::whereName('spirit')->first()->image;

        return $this->draw();
    }

    public function notFound()
    {
        $this->template = 'errors.site.404';

        return $this->draw();
    }

    private function draw()
    {
        return view($this->template, $this->data);
    }
}
