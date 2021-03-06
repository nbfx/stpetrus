<?php

namespace App\Http\Controllers;

use App\Language;
use App\SpiritGroup as Model;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SpiritGroupController extends AdminController
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
        $this->setModel($this->model)
            ->setPrefix('spirit_groups')
            ->setPageTitleAdd(trans('admin.pages.titles.add.spiritGroups'))
            ->setPageTitleList(trans('admin.pages.titles.list.spiritGroups'))
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
                'image' => [
                    'label' => trans('admin.pages.fields.image'),
                    'type' => 'input',
                    'inputType' => 'file',
                    'required' => true,
                    'helpText' => trans('admin.pages.helpText.jpgOrPng'),
                ],
                'preview_image' => [
                    'label' => trans('admin.pages.fields.previewImage'),
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
     * Show List page
     *
     * @return View
     */
    public function list()
    {
        $items = Model::orderBy('order')->get()->toArray();
        foreach ($items as $index => $item) {
            if (forward_static_call([$this->getModel(), 'hasChildren'], $item['id'])) {
                $items[$index]['children'] = forward_static_call([$this->getModel(), 'getChildren'], $item['id'])->toArray();
            }
        }
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
            'isOrderable' => $this->isOrderable(),
            'listTranslatable' => $this->isListTranslatable() && count($languages) > 1,
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
            'name' => $request->get('name'),
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
        if ($request->file('preview_image')) {
            if ($itemId && $oldImage = Model::find($itemId)->preview_image)
                if(file_exists($oldImage)) @unlink($oldImage);
            $previewExtension = $request->file('preview_image')->getClientOriginalExtension();
            $previewImageName = 'preview_'.rand(1000, 999999).'_'.time().'.'.$previewExtension;
            if (!is_dir("img/{$this->getPrefix()}")) mkdir("img/{$this->getPrefix()}");
            $request->file('preview_image')->move(base_path() . "/public/img/{$this->getPrefix()}/", $previewImageName);
            $data['preview_image'] = "img/{$this->getPrefix()}/$previewImageName";
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

        return redirect(route("{$this->getPrefix()}_list"));
    }
}
