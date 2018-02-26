<?php

namespace App;

use App\Helpers\TableProperties;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WineItem
 * @package App
 *
 * @property integer $id
 * @property integer $parent
 * @property string $title
 * @property float $price
 * @property string $description
 * @property integer $order
 * @property boolean $disabled
 *
 * @method static whereId($value)
 * @method static whereParent($value)
 * @method static whereTitle($value)
 * @method static wherePrice($value)
 * @method static whereDescription($value)
 * @method static whereOrder($value)
 * @method static whereDisabled($value)
 */
class WineItem extends Model
{
    use TableProperties;

    public $timestamps = false;

    public $translatable = [
        'title',
        'description',
    ];

    protected $guarded = [];

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

    public function group()
    {
        return $this->belongsTo('App\WineGroup', 'parent', 'id');
    }
}
