<?php

namespace App\Http\Controllers;

use App\Slider as Model;
use App\Language;
use App\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SliderController extends AdminController
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
        $this->setModel($this->model)
            ->setPrefix('slider')
            ->setPageTitleAdd(trans('admin.pages.titles.add.slider'))
            ->setPageTitleList(trans('admin.pages.titles.list.slider'))
            ->setIsOrderable(true)
            ->setIsEditable(false)
            ->setFields([
                'speed_ms' => [
                    'label' => trans('admin.pages.fields.speed_ms'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'pause_ms' => [
                    'label' => trans('admin.pages.fields.pause_ms'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
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
        $data = Model::first();
        $items = Model::getChildren($data->id);

        $languages = $this->model->translatable ? Language::orderBy('order')->get()->toArray() : [];
        array_unshift($languages, ['title' => config('app.language'), 'locale' => config('app.fallback_locale')]);

        return view("admin.pages.edit.slider", [
            'oldData' => collect($data->toArray()),
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
        $slider = Model::first();
        $data = [
            'speed_ms' => $request->get('speed_ms'),
            'pause_ms' => $request->get('pause_ms'),
            'description' => $request->get('description'),
        ];

        foreach ($this->model->translatable as $field) {
            foreach (Language::all()->pluck('locale')->toArray() as $locale) {
                $data[$field."_$locale"] = $request->get($field."_$locale");
            }
        }

        $slider->update($data);

        return redirect(route("{$this->getPrefix()}_edit"));
    }
}
