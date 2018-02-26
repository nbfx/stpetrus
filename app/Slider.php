<?php

namespace App;

use App\Helpers\TableProperties;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class Slider
 * @package App
 *
 * @property integer $id
 * @property integer $speed_ms = 500
 * @property integer $pause_ms = 4000
 * @property string $description
 * @property boolean $disabled
 *
 * @method static whereId($value)
 * @method static whereSpeedMs($value)
 * @method static wherePauseMs($value)
 * @method static whereDescription($value)
 * @method static whereDisabled($value)
 */
class Slider extends Model
{
    use TableProperties;

    protected $table = 'slider';

    public $timestamps = false;

    protected $guarded = [];

    public $translatable = [];

    /**
     * Get children of item
     *
     * @param int $id
     * @return null
     */
    public static function getChildren(int $id)
    {
        return self::hasChildren($id) ? Slide::whereSliderId($id)->orderBy('order')->get() : null;
    }

    /**
     * Return true if item has children
     *
     * @param int $id
     * @return bool
     */
    public static function hasChildren(int $id)
    {
        return !!Slide::whereSliderId($id)->count();
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
