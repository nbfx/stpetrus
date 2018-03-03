<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback as Model;

class FeedbackController extends AdminController
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
        $this->setModel($this->model)
            ->setPrefix('feedback')
            ->setIsRemovable(false);
    }

    public function list()
    {
        $items = Model::all();
        $data = [];
        foreach ($items as $item) {
            $data[$item->status][] = $item->toArray();
        }

        return view("admin.pages.list.{$this->getPrefix()}", [
            'data' => $data,
            'prefix' => $this->getPrefix(),
        ]);
    }
}
