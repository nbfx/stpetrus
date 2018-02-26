<?php

namespace App\Http\Controllers;

use App\Language;
use App\Teammate as Model;
use Illuminate\Http\Request;

class TeammateController extends AdminController
{

    private $model;

    public function __construct()
    {
        $this->model = new Model();
        $this->setModel($this->model)
            ->setPrefix('teammates')
            ->setPageTitleAdd(trans('admin.pages.titles.add.teammates'))
            ->setPageTitleList(trans('admin.pages.titles.list.teammates'))
            ->setIsOrderable(true)
            ->setFields([
                'f_name' => [
                    'label' => trans('admin.pages.fields.f_name'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'l_name' => [
                    'label' => trans('admin.pages.fields.l_name'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'position' => [
                    'label' => trans('admin.pages.fields.position'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'text' => [
                    'label' => trans('admin.pages.fields.essay'),
                    'type' => 'textarea',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'description' => [
                    'label' => trans('admin.pages.fields.description'),
                    'type' => 'textarea',
                    'inputType' => 'text',
                    'required' => false,
                ],
                'image' => [
                    'label' => trans('admin.pages.fields.photo'),
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
            'f_name' => $request->get('f_name'),
            'l_name' => $request->get('l_name'),
            'title' => $request->get('f_name') . ' ' . $request->get('l_name'),
            'position' => $request->get('position'),
            'text' => $request->get('text'),
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
        $locales = Language::all()->pluck('locale')->toArray();
        foreach ($this->model->translatable as $field) {
            foreach ($locales as $locale) {
                $data[$field."_$locale"] = $request->get($field."_$locale");
            }
        }
        foreach ($locales as $locale) {
            $data["title_$locale"] = $data["f_name_$locale"] . ' ' . $data["l_name_$locale"];
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

        return redirect(route("{$this->getPrefix()}_list"));
    }
}
