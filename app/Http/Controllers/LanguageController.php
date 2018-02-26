<?php

namespace App\Http\Controllers;

use App\Language as Model;
use App\Language;
use Illuminate\Http\Request;

class LanguageController extends AdminController
{

    private $model;

    public function __construct()
    {
        $this->model = new Model();
        $this->setModel($this->model)
            ->setPrefix('languages')
            ->setPageTitleAdd(trans('admin.pages.titles.add.languages'))
            ->setPageTitleList(trans('admin.pages.titles.list.languages'))
            ->setIsOrderable(true)
            ->setListTranslatable(false)
            ->setFields([
                'title' => [
                    'label' => trans('admin.pages.fields.language'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'locale' => [
                    'label' => trans('admin.pages.fields.locale'),
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
        $data = [
            'title' => $request->get('title'),
            'locale' => $request->get('locale'),
            'description' => $request->get('description'),
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

        return redirect(route("{$this->getPrefix()}_list"));
    }
}
