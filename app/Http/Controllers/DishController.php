<?php

namespace App\Http\Controllers;

use App\Dish as Model;
use App\Language;
use Illuminate\Http\Request;

class DishController extends AdminController
{

    private $model;

    public function __construct()
    {
        $this->model = new Model();
        $this->setModel($this->model)
            ->setPrefix('dishes')
            ->setPageTitleAdd(trans('admin.pages.titles.add.dishes'))
            ->setPageTitleList(trans('admin.pages.titles.list.dishes'))
            ->setIsOrderable(true)
            ->setFields([
                'title' => [
                    'label' => trans('admin.pages.fields.title'),
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request)
    {
        $itemId = $request->get('id');
        $data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'order' => $request->get('order'),
            'disabled' => (bool)$request->get('disabled'),
        ];

        if ($request->file('image')) {
            if ($itemId && $oldImage = Model::find($itemId)->image) {
                if(file_exists($oldImage)) @unlink($oldImage);
            }
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

        if (!$itemId)
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

        if($itemId && $item = Model::find($itemId)) {
            $item->update($data);
        } else {
            Model::create($data);
        }

        return redirect(route("{$this->getPrefix()}_list"));
    }
}
