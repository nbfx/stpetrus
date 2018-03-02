<?php

namespace App\Http\Controllers;

use App\Slide as Model;
use App\Language;
use App\Slider;
use Illuminate\Http\Request;

class SlideController extends AdminController
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
        $this->setModel($this->model)
            ->setPrefix('slides')
            ->setPageTitleAdd(trans('admin.pages.titles.add.slides'))
            ->setPageTitleList(trans('admin.pages.titles.list.slides'))
            ->setIsOrderable(true)
            ->setIsEditable(false)
            ->setFields([
                'image' => [
                    'label' => trans('admin.pages.fields.image'),
                    'type' => 'input',
                    'inputType' => 'file',
                    'required' => true,
                    'helpText' => trans('admin.pages.helpText.jpgOrPng'),
                ],
                'disabled' => [
                    'label' => trans('admin.pages.fields.disabled'),
                    'type' => 'input',
                    'inputType' => 'checkbox',
                    'required' => false,
                ],
            ]);
    }

    public function add()
    {
        if ($this->isParentable()) {
            $items = forward_static_call([$this->getModel(), 'whereParent'], null)->orderBy('order')->get()->toArray();
            foreach ($items as $index => $item) {
                if (forward_static_call([$this->getModel(), 'hasChildren'], $item['id'])) {
                    $items[$index]['children'] = forward_static_call([$this->getModel(), 'getChildren'], $item['id'])->toArray();
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

        return view("admin.pages.add.slide", [
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
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request)
    {
        $data = [
            'slider_id' => Slider::first()->id,
            'order' => $request->get('order'),
            'disabled' => (bool)$request->get('disabled'),
        ];
        if ($request->file('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = rand(1000, 999999).'_'.time().'.'.$extension;
            if (!is_dir("img/{$this->getPrefix()}")) mkdir("img/{$this->getPrefix()}");
            $request->file('image')->move(base_path() . "/public/img/{$this->getPrefix()}/", $imageName);
            $data['image'] = "img/{$this->getPrefix()}/$imageName";
        }

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

        return redirect(route("slider_edit"));
    }
}
