<?php

namespace App\Http\Controllers;

use App\Language;
use App\Contact as Model;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ContactController extends AdminController
{

    private $model;

    public function __construct()
    {
        $this->model = new Model();
        $this->setModel($this->model)
            ->setPrefix('contacts')
            ->setPageTitleAdd(trans('admin.pages.titles.add.contacts'))
            ->setPageTitleList(trans('admin.pages.titles.list.contacts'))
            ->setFields([
                'phone' => [
                    'label' => trans('admin.pages.fields.phone'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'address' => [
                    'label' => trans('admin.pages.fields.address'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'email' => [
                    'label' => trans('admin.pages.fields.email'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'social_networks' => [
                    'label' => trans('admin.pages.fields.social_networks'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => false,
                ],
                /*'map_lat' => [
                    'label' => trans('admin.pages.fields.map_lat'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => false,
                ],
                'map_lng' => [
                    'label' => trans('admin.pages.fields.map_lng'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => false,
                ],*/
                'map_link' => [
                    'label' => trans('admin.pages.fields.map_link'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => false,
                ],
                'description' => [
                    'label' => trans('admin.pages.fields.description'),
                    'type' => 'textarea',
                    'inputType' => 'text',
                    'required' => false,
                ],
            ]);
    }

    /**
     * Show Edit page
     *
     * @param $id integer
     * @return View
     */
    public function edit(int $id = null)
    {
        $this->setPageTitleEdit(trans('admin.pages.titles.edit.general'));
        $data = Model::first()->toArray();

        $languages = $this->model->translatable ? Language::orderBy('order')->get()->toArray() : [];
        array_unshift($languages, ['title' => config('app.language'), 'locale' => config('app.fallback_locale')]);

        return view("admin.pages.edit.contacts", [
            'oldData' => collect($data),
            'pageTitle' => $this->getPageTitleEdit(),
            'items' => $data,
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
        $itemId = Model::first()->id;
        $data = [
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
            'map_lat' => $request->get('map_lat'),
            'map_lng' => $request->get('map_lng'),
            'map_link' => preg_replace("/(width|height)[ \=][\"\']([\d]+)[\"\']/i", '$1="100%"', $request->get('map_link')),
            'social_networks' => $request->get('social_networks'),
            'description' => $request->get('description'),
        ];

        $locales = Language::all()->pluck('locale')->toArray();
        foreach ($this->model->translatable as $field) {
            foreach ($locales as $locale) {
                $data[$field."_$locale"] = $request->get($field."_$locale");
            }
        }

        if($itemId && $item = Model::find($itemId)) {
            $item->update($data);
        }

        return redirect(route("{$this->getPrefix()}_edit"));
    }
}
