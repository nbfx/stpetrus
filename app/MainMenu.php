<?php

namespace App;

use App\Helpers\NameHelper;
use App\Helpers\TableProperties;
use Illuminate\Database\Eloquent\Model;


/**
 * Class MainMenu
 * @package App
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property integer $parent
 * @property string $description
 * @property integer $order
 *
 * @method static whereId($value)
 * @method static whereTitle($value)
 * @method static whereName($value)
 * @method static whereParent($value)
 * @method static whereDescription($value)
 * @method static whereOrder($value)
 */
class MainMenu extends Model
{
    use TableProperties;

    public $timestamps = false;

    public $translatable = [
        'title',
        'description',
    ];

    protected $table = 'main_menu';

    protected $guarded = [];

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model)
        {
            if (!$model->name) $model->name = NameHelper::generateNameByTitle($model->title);
        });

        static::deleting(function($model) {
            if(self::hasChildren($model->id)) {
                self::whereIn('id', self::getChildren($model->id)->pluck('id')->toArray())->delete();
            }
        });
    }

    /**
     * Get children of item
     *
     * @param int $id
     * @return null
     */
    public static function getChildren(int $id)
    {
        return self::hasChildren($id) ? self::whereParent($id)->orderBy('order')->get() : null;
    }

    /**
     * Return true if item has children
     *
     * @param int $id
     * @return bool
     */
    public static function hasChildren(int $id)
    {
        return !!self::whereParent($id)->count();
    }

    /**
     * Get items that are not children
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getOnlyParents()
    {
        foreach ($result = self::orderBy('order')->get() as $index => $item) {
            if ($item->parent != null) unset($result[$index]);
        }

        return $result;
    }

    /**
     * Swap items
     *
     * @param int $id1
     * @param int $id2
     * @return boolean
     */
    public static function swap(int $id1, int $id2)
    {
        $item1 = self::find($id1);
        $item2 = self::find($id2);
        if($item1->count() && $item2->count()) {
            $old = $item1->order;
            $item1->update(['order' => $item2->order]);
            $item2->update(['order' => $old]);

            return true;
        }

        return false;
    }

    public static function toggleDisabled(int $id)
    {
        if ($item = self::find($id)) {
            $item->update(['disabled' => !$item->disabled]);
            $answer = json_encode(['success' => true, 'disabled' => $item->disabled]);
        }

        return $answer ?? json_encode(['success' => false]);
    }
}
