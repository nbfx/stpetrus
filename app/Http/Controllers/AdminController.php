<?php


namespace App\Http\Controllers;

use App\Http\Requests;
use App\Language;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    private $model;

    /** @var string */
    private $prefix;

    /** @var string */
    private $pageTitleList;

    /** @var string */
    private $pageTitleAdd;

    /** @var string */
    private $pageTitleEdit = '';

    /** @var array */
    public $fields;

    /** @var bool */
    public $isOrderable = false;

    /** @var bool */
    public $isParentable = false;

    /** @var bool */
    public $isRemovable = true;

    /** @var bool */
    public $isEditable = true;

    /** @var bool */
    public $listTranslatable = true;

    /**
     * Set prefix (table name, entity key etc.)
     *
     * @param string $prefix
     * @return $this
     */
    public function setPrefix(string $prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix (table name, entity key etc.)
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the Model class
     *
     * @param $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model class
     *
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set string to show in List page title
     *
     * @param string $pageTitleList
     * @return $this
     */
    public function setPageTitleList(string $pageTitleList)
    {
        $this->pageTitleList = $pageTitleList;

        return $this;
    }

    /**
     * Get string to show in List page title
     *
     * @return string
     */
    public function getPageTitleList()
    {
        return $this->pageTitleList;
    }

    /**
     * Set string to show in Add page title
     *
     * @param string $pageTitleAdd
     * @return $this
     */
    public function setPageTitleAdd(string $pageTitleAdd)
    {
        $this->pageTitleAdd = $pageTitleAdd;

        return $this;
    }

    /**
     * Get string to show in Add page title
     *
     * @return string
     */
    public function getPageTitleAdd()
    {
        return $this->pageTitleAdd;
    }

    /**
     * Set string to show in Edit page title
     *
     * @param string $pageTitleEdit
     * @return $this
     */
    public function setPageTitleEdit(string $pageTitleEdit)
    {
        $this->pageTitleEdit = $pageTitleEdit;

        return $this;
    }

    /**
     * Get string to show in Edit page title
     *
     * @return string
     */
    public function getPageTitleEdit()
    {
        return $this->pageTitleEdit;
    }

    /**
     * Set isOrderable switch
     *
     * @param bool $status
     * @return $this
     */
    public function setIsOrderable(bool $status)
    {
        $this->isOrderable = $status;

        return $this;
    }

    /**
     * Get isOrderable switch value
     *
     * @return bool
     */
    public function isOrderable():bool
    {
        return $this->isOrderable;
    }

    /**
     * Set isParentable switch
     *
     * @param bool $status
     * @return $this
     */
    public function setIsParentable(bool $status)
    {
        $this->isParentable = $status;

        return $this;
    }

    /**
     * Get isParentable switch value
     *
     * @return bool
     */
    public function isParentable():bool
    {
        return $this->isParentable;
    }

    /**
     * Set isRemovable switch
     *
     * @param bool $status
     * @return $this
     */
    public function setIsRemovable(bool $status)
    {
        $this->isRemovable = $status;

        return $this;
    }

    /**
     * Get isRemovable switch value
     *
     * @return bool
     */
    public function isRemovable():bool
    {
        return $this->isRemovable;
    }

    /**
     * Set isEditable switch
     *
     * @param bool $status
     * @return $this
     */
    public function setIsEditable(bool $status)
    {
        $this->isEditable = $status;

        return $this;
    }

    /**
     * Get isEditable switch value
     *
     * @return bool
     */
    public function isEditable():bool
    {
        return $this->isEditable;
    }

    /**
     * Set List translatable switch. If status = true, language tabs will be shown
     *
     * @param bool $status
     * @return $this
     */
    public function setListTranslatable(bool $status)
    {
        $this->listTranslatable = $status;

        return $this;
    }

    /**
     * Get list translatable switch value
     *
     * @return bool
     */
    public function isListTranslatable():bool
    {
        return $this->listTranslatable;
    }

    /**
     * Set fields to show in Add page
     *
     * @param array $fields
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get fields for Add page
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Show List page
     *
     * @return View
     */
    public function list()
    {
        if ($this->isParentable()) {
            $items = forward_static_call([$this->getModel(), 'whereParent'], null)->orderBy('order')->get()->toArray();
            foreach ($items as $index => $item) {
                if (forward_static_call([$this->getModel(), 'hasChildren'], $item['id'])) {
                    $items[$index]['children'] = forward_static_call([$this->getModel(), 'getChildren'], $item['id'])->toArray();
                }
            }
        } else {
            if ($this->isOrderable()){
                $items = forward_static_call([$this->getModel(), 'orderBy'], 'order')->get()->toArray();
            } else {
                $items = $this->getModel()->get()->toArray();
            }

        }

        $languages = $this->model->translatable ? Language::orderBy('order')->get()->toArray() : [];
        array_unshift($languages, ['title' => config('app.language'), 'locale' => config('app.fallback_locale')]);

        return view("admin.pages.list.{$this->prefix}", [
            'pageTitle' => $this->getPageTitleList(),
            'items' => $items,
            'prefix' => $this->getPrefix(),
            'languages' => $languages,
            'fields' => $this->getFields(),
            'translatableFields' => $this->model->translatable,
            'isRemovable' => $this->isRemovable(),
            'isOrderable' => $this->isOrderable(),
            'isEditable' => $this->isEditable(),
            'listTranslatable' => $this->isListTranslatable() && count($languages) > 1,
        ]);
    }

    /**
     * Show Add page
     *
     * @return View
     */
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

        return view("admin.pages.add", [
            'pageTitle' => $this->getPageTitleAdd(),
            'items' => $items,
            'prefix' => $this->prefix,
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
     * Show Edit page
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id)
    {
        $this->setPageTitleEdit(trans('admin.pages.titles.edit.general'));
        $data = forward_static_call([$this->getModel(), 'findOrFail'], $id)->toArray();


        if ($this->isParentable()) {
            $items = forward_static_call([$this->getModel(), 'whereParent'], null)->orderBy('order')->get()->toArray();
            foreach ($items as $index => $item) {
                if (forward_static_call([$this->getModel(), 'hasChildren'], $item['id'])) {
                    $items[$index]['children'] = forward_static_call([$this->getModel(), 'getChildren'], $item['id'])->toArray();
                }
            }
        } else {
            if ($this->isOrderable()){
                $items = forward_static_call([$this->getModel(), 'orderBy'], 'order')->get();
            } else {
                $items = $this->getModel()->get();
            }
        }

        $languages = $this->model->translatable ? Language::orderBy('order')->get()->toArray() : [];
        array_unshift($languages, ['title' => config('app.language'), 'locale' => config('app.fallback_locale')]);

        return view("admin.pages.edit", [
            'oldData' => collect($data),
            'pageTitle' => $this->getPageTitleEdit(),
            'items' => $items,
            'prefix' => $this->prefix,
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
     * Swap items from list
     *
     * @param Request $request
     * @return string
     */
    public function swap(Request $request)
    {
        if (empty($request->all()['ids']) || !isset($request->all()['ids'][0]) || !isset($request->all()['ids'][1]))
            return json_encode([
                'success' => false,
                'message' => 'IDs required',
            ]);
        else {
            $ids = $request->all()['ids'];
            forward_static_call([$this->getModel(), 'swap'], $ids[0], $ids[1]);

            return json_encode(['success' => true]);
        }
    }

    /**
     * Disable or enable item
     *
     * @param Request $request
     * @return string
     */
    public function toggleDisabled(Request $request)
    {
        $id = $request->get('id');
        if (!$id)
            return json_encode([
                'success' => false,
                'message' => 'ID required',
            ]);
        else {
            return forward_static_call([$this->getModel(), 'toggleDisabled'], $id);
        }
    }

    /**
     * Remove item from list
     *
     * @param Request $request
     * @return string
     */
    public function remove(Request $request)
    {
        if (empty($request->all()['id']))
            return json_encode([
                'success' => false,
                'message' => 'ID required',
            ]);
        else {
            forward_static_call([$this->getModel(), 'find'], $request->all()['id'])->delete();

            return json_encode(['success' => true]);
        }
    }

    public function validateFields(Request $request)
    {
        $answer = ['success' => true];
        foreach ($this->getFields() as $field => $params) {
            if ($params['required'] && (!in_array($field, array_keys($request->all())) || empty(trim($request->get($field))))) {
                $answer['success'] = false;
                $answer['errors'][$field] = trans('admin.pages.validationMessages.fieldRequired');
            }
        }

        return json_encode($answer);
    }

    public function notFound()
    {
        return view('errors.admin.404');
    }
}
