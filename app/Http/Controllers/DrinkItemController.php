<?php

namespace App\Http\Controllers;

use App\Language;
use App\DrinkGroup;
use App\DrinkItem as Model;
use App\DrinkGroup as ParentModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DrinkItemController extends AdminController
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
        $this->setModel($this->model)
            ->setPrefix('drink_items')
            ->setPageTitleAdd(trans('admin.pages.titles.add.drinkItems'))
            ->setPageTitleList(trans('admin.pages.titles.list.drinkItems'))
            ->setIsOrderable(false)
            ->setIsParentable(true)
            ->setFields([
                'title' => [
                    'label' => trans('admin.pages.fields.title'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'price' => [
                    'label' => trans('admin.pages.fields.price'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'description' => [
                    'label' => trans('admin.pages.fields.description'),
                    'type' => 'textarea',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'disabled' => [
                    'label' => trans('admin.pages.fields.disabled'),
                    'type' => 'input',
                    'inputType' => 'checkbox',
                    'required' => false,
                ],
            ]);
    }

    public function list()
    {
        if(!DrinkGroup::all()->count()) {
            return redirect(route('admin'));
        }
        $items = Model::with('group')->orderBy('order')->get()->toArray();
        $languages = $this->model->translatable ? Language::orderBy('order')->get()->toArray() : [];
        array_unshift($languages, ['title' => config('app.language'), 'locale' => config('app.fallback_locale')]);

        return view("admin.pages.list.{$this->getPrefix()}", [
            'pageTitle' => $this->getPageTitleList(),
            'items' => $items,
            'prefix' => $this->getPrefix(),
            'languages' => $languages,
            'fields' => $this->getFields(),
            'translatableFields' => $this->model->translatable,
            'isRemovable' => $this->isRemovable(),
            'isEditable' => $this->isEditable(),
            'listTranslatable' => $this->isListTranslatable() && count($languages) > 1,
        ]);
    }

    /**
     * Show Add page
     *
     * @return View
     */
    /*public function add()
    {
        if ($this->isParentable()) {
            $items = ParentModel::orderBy('order')->get()->toArray();
            foreach ($items as $index => $item) {
                if (ParentModel::hasChildren($item['id'])) {
                    $items[$index]['children'] = ParentModel::getChildren($item['id'])->toArray();
                }
            }
        } else {
            if ($this->isOrderable()) {
                $items = forward_static_call([$this->getModel(), 'orderBy'], 'order')->get();
            } else {
                $items = $this->getModel()->get();
            }

        }
        die(var_dump($items));

        $languages = $this->model->translatable ? Language::orderBy('order')->get()->toArray() : [];
        array_unshift($languages, ['title' => config('app.language'), 'locale' => config('app.fallback_locale')]);

        return view("admin.pages.add.menu_item", [
            'pageTitle' => $this->getPageTitleAdd(),
            'items' => $items,
            'prefix' => $this->getPrefix(),
            'languages' => $languages,
            'fields' => $this->getFields(),
            'translatableFields' => $this->model->translatable,
            'isOrderable' => $this->isOrderable(),
            'isParentable' => $this->isParentable(),
            'isRemovable' => $this->isRemovable(),
            'isEditable' => $this->isEditable(),
            'mustHaveParent' => true,
        ]);
    }*/

    public function add()
    {
        if ($this->isParentable()) {
            $items = ParentModel::orderBy('order')->get()->toArray();
            foreach ($items as $index => $item) {
                if (ParentModel::hasChildren($item['id'])) {
                    $items[$index]['children'] = ParentModel::getChildren($item['id'])->toArray();
                }
            }
        } else {
            if ($this->isOrderable()) {
                $items = forward_static_call([$this->getModel(), 'orderBy'], 'order')->get();
            } else {
                $items = $this->getModel()->get();
            }

        }

        $languages = $this->model->translatable ? Language::orderBy('order')->get()->toArray() : [];
        array_unshift($languages, ['title' => config('app.language'), 'locale' => config('app.fallback_locale')]);

        return view("admin.pages.add.drink_item", [
            'pageTitle' => $this->getPageTitleAdd(),
            'items' => $items,
            'prefix' => $this->getPrefix(),
            'languages' => $languages,
            'fields' => $this->getFields(),
            'translatableFields' => $this->model->translatable,
            'isOrderable' => $this->isOrderable(),
            'isParentable' => $this->isParentable(),
            'isRemovable' => $this->isRemovable(),
            'isEditable' => $this->isEditable(),
            'mustHaveParent' => true,
        ]);
    }

    /**
     * Show Edit page
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id)
    {
        if(!DrinkGroup::all()->count()) {
            return redirect(route('admin'));
        }
        $this->setPageTitleEdit(trans('admin.pages.titles.edit.general'));
        $data = forward_static_call([$this->getModel(), 'findOrFail'], $id)->toArray();

        $items = DrinkGroup::orderBy('order')->get()->toArray();

        $languages = $this->model->translatable ? Language::orderBy('order')->get()->toArray() : [];
        array_unshift($languages, ['title' => config('app.language'), 'locale' => config('app.fallback_locale')]);

        return view("admin.pages.edit.drink_item", [
            'oldData' => collect($data),
            'pageTitle' => $this->getPageTitleEdit(),
            'items' => $items,
            'prefix' => $this->getPrefix(),
            'languages' => $languages,
            'fields' => $this->getFields(),
            'translatableFields' => $this->model->translatable,
            'isOrderable' => $this->isOrderable(),
            'isParentable' => $this->isParentable(),
            'isRemovable' => $this->isRemovable(),
            'isEditable' => $this->isEditable(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request)
    {
        $data = [
            'title' => $request->get('title'),
            'price' => str_replace(',', '.', $request->get('price')),
            'description' => $request->get('description'),
            'parent' => $request->get('parent'),
            'order' => $request->get('order'),
            'disabled' => (bool)$request->get('disabled'),
        ];

        foreach ($this->model->translatable as $field) {
            foreach (Language::all()->pluck('locale')->toArray() as $locale) {
                $data[$field."_$locale"] = $request->get($field."_$locale");
            }
        }

        if (!$request->get('id'))
            switch (true) {
                case ($data['order'] == 'first'):
                    if(Model::whereOrder(0)) Model::where('id', '>=', 0)->increment('order');
                    $data['order'] = 0;
                    break;
                case (strpos($data['order'], 'after') !== false):
                    $order = explode(':', $data['order'])[1] + 1;
                    Model::where('order', '>=', $order)->increment('order');
                    $data['order'] = $order;
                    break;
                case ($data['order'] == 'last'):
                default:
                    $data['order'] = Model::all()->max('order') + 1;
            }

        if($request->get('id') && $item = Model::find($request->get('id'))) {
            $item->update($data);
        } else {
            Model::create($data);
        }

        return redirect(route("drinks_list"));
    }
}
