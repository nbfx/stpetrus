<?php

namespace App;

use App\Helpers\TableProperties;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Teammate
 * @package App
 *
 * @property integer $id
 * @property string $f_name
 * @property string $l_name
 * @property string $title
 * @property string $position
 * @property string $description
 * @property string $text
 * @property string $image
 * @property integer $order
 *
 * @method static whereId($value)
 * @method static whereFName($value)
 * @method static whereLName($value)
 * @method static whereTitle($value)
 * @method static wherePosition($value)
 * @method static whereDescription($value)
 * @method static whereText($value)
 * @method static whereImage($value)
 * @method static whereOrder($value)
 */
class Teammate extends Model
{
    use TableProperties;

    public $timestamps = false;

    public $translatable = [
        'f_name',
        'l_name',
        'title',
        'position',
        'text',
        'description',
    ];

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model)
        {
            $model->title = "$model->f_name $model->l_name";
        });
        static::updating(function ($model)
        {
            $model->title = "$model->f_name $model->l_name";
        });
    }

    public function delete()
    {
        if(file_exists($this->image)) @unlink($this->image);

        parent::delete();
    }
    
    /**
     * @param int $id1
     * @param int $id2
     * @return bool
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
