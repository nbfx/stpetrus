<?php

namespace App;

use App\Helpers\NameHelper;
use App\Helpers\TableProperties;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 * @package App
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property string $description
 * @property string $text
 * @property string $image
 * @property \DateTime $date_time
 * @property boolean $disabled
 * @property integer $order
 *
 * @method static whereId($value)
 * @method static whereTitle($value)
 * @method static whereName($value)
 * @method static whereDescription($value)
 * @method static whereText($value)
 * @method static whereImage($value)
 * @method static whereDateTime($value)
 * @method static whereDisabled($value)
 * @method static whereOrder($value)
 */
class Event extends Model
{
    use TableProperties;

    public $timestamps = false;

    public $translatable = [
        'title',
        'description',
        'text',
        'image',
    ];

    protected $guarded = ['name'];

    public function delete()
    {
        if(file_exists($this->{"image"})) @unlink($this->{"image"});
        foreach (Language::all()->pluck('locale')->toArray() as $locale) {
            $suffix = $locale == config('app.fallback_locale') ? '' : "_$locale";
            if(file_exists($this->{"image$suffix"})) @unlink($this->{"image$suffix"});
        }

        parent::delete();
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model)
        {
            $model->name = NameHelper::generateNameByTitle($model->title);
        });
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
