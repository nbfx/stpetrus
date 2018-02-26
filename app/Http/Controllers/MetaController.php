<?php

namespace App\Http\Controllers;

use App\Meta as Model;
use Illuminate\Http\Request;

class MetaController extends AdminController
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
        $this->setModel($this->model)
            ->setPrefix('meta')
            ->setPageTitleAdd(trans('admin.pages.titles.add.meta'))
            ->setPageTitleList(trans('admin.pages.titles.list.meta'))
            ->setFields([
                'name' => [
                    'label' => trans('admin.pages.fields.name'),
                    'type' => 'input',
                    'inputType' => 'text',
                    'required' => true,
                ],
                'content' => [
                    'label' => trans('admin.pages.fields.content'),
                    'type' => 'input',
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request)
    {
        $itemId = $request->get('id');
        $data = [
            'name' => $request->get('name'),
            'content' => $request->get('content'),
            'disabled' => (bool)$request->get('disabled'),
        ];

        if($itemId && $item = Model::find($itemId)) {
            $item->update($data);
        } else {
            Model::create($data);
        }

        return redirect(route("{$this->getPrefix()}_list"));
    }
}
