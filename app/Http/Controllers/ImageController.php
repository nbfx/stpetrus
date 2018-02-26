<?php

namespace App\Http\Controllers;

use App\Helpers\NameHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    private $img = 'img';

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $files = File::allFiles($this->img);
        foreach ($files as $file) {
            preg_match("/img\/([\w]+)\/{$file->getFilename()}/", $file->getPathname(), $prefix);
            $items[] = [
                'filename' => $file->getFilename(),
                'pathname' => $file->getPathname(),
                'cTime' => $file->getcTime(),
                'size' => $file->getSize(),
                'parentModel' => NameHelper::snakeToCamel($prefix[1] ?? '') ?? null,
            ];
        }


        return view('admin.pages.list.images', [
            'pageTitle' => trans('admin.sidebar.images'),
            'items' => $items ?? [],
        ]);
    }

    public function remove(Request $request)
    {
        if (empty($request->get('id')))
            return json_encode([
                'success' => false,
                'message' => 'Name required',
            ]);
        else {
            if(file_exists($request->get('id'))) @unlink($request->get('id'));

            return json_encode(['success' => true]);
        }
    }
}
