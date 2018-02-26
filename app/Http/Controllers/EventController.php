<?php

namespace App\Http\Controllers;

use App\Event as Model;
use App\Language;
use Illuminate\Http\Request;

class EventController extends AdminController
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
        $this->setModel($this->model)
            ->setPrefix('events')
            ->setPageTitleAdd(trans('admin.pages.titles.add.events'))
            ->setPageTitleList(trans('admin.pages.titles.list.events'))
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
                    'required' => false,
                ],
                'text' => [
                    'label' => trans('admin.pages.fields.text'),
                    'type' => 'wysiwyg',
                    'required' => true,
                ],
                'image' => [
                    'label' => trans('admin.pages.fields.image'),
                    'type' => 'input',
                    'inputType' => 'file',
                    'required' => false,
                    'helpText' => trans('admin.pages.helpText.jpgOrPng'),
                ],
                'date_time' => [
                    'label' => trans('admin.pages.fields.date'),
                    'type' => 'input',
                    'inputType' => 'dateTimePicker',
                    'required' => false,
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
            'text' => $request->get('text'),
            'date_time' => $request->get('date_time'),
            'order' => $request->get('order'),
            'disabled' => (bool)$request->get('disabled'),
        ];

        if ($request->file("image")) {
            if ($itemId && $oldImage = Model::find($itemId)->{"image"}) {
                if(file_exists($oldImage)) @unlink($oldImage);
            }
            $extension = $request->file("image")->getClientOriginalExtension();
            $imageName = rand(1000, 999999).'_'.time().'.'.$extension;
            if (!is_dir("img/{$this->getPrefix()}")) mkdir("img/{$this->getPrefix()}");
            $request->file("image")->move(base_path() . "/public/img/{$this->getPrefix()}/", $imageName);
            $data["image"] = "img/{$this->getPrefix()}/$imageName";
        }

        foreach (Language::all()->pluck('locale')->toArray() as $locale) {
            $suffix = $locale == config('app.fallback_locale') ? '' : "_$locale";
            if ($request->file("image$suffix")) {
                if ($itemId && $oldImage = Model::find($itemId)->{"image$suffix"}) {
                    if(file_exists($oldImage)) @unlink($oldImage);
                }
                $extension = $request->file("image$suffix")->getClientOriginalExtension();
                $imageName = rand(1000, 999999).'_'.time().$suffix.'.'.$extension;
                if (!is_dir("img/{$this->getPrefix()}")) mkdir("img/{$this->getPrefix()}");
                $request->file("image$suffix")->move(base_path() . "/public/img/{$this->getPrefix()}/", $imageName);
                $data["image$suffix"] = "img/{$this->getPrefix()}/$imageName";
            }
        }

        foreach ($this->model->translatable as $field) {
            if ($field != 'image') {
                foreach (Language::all()->pluck('locale')->toArray() as $locale) {
                    $data[$field . "_$locale"] = $request->get($field . "_$locale");
                }
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

        return redirect(route("{$this->getPrefix()}_list"));
    }
}
