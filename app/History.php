<?php

namespace App;

use App\Helpers\TableProperties;
use Illuminate\Database\Eloquent\Model;

/**
 * Class History
 * @package App
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $image
 * @property integer $order
 *
 * @method static whereId($value)
 * @method static whereTitle($value)
 * @method static whereDescription($value)
 * @method static whereText($value)
 * @method static whereImage($value)
 * @method static whereOrder($value)
 */
class History extends Model
{
    use TableProperties;

    public $timestamps = false;

    public $translatable = [
        'title',
        'description',
        'text',
    ];

    protected $guarded = [];

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
