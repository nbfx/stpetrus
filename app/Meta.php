<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Meta
 * @package App
 *
 * @property integer $id
 * @property string $name
 * @property string $content
 * @property string $disabled
 *
 * @method static whereId($value)
 * @method static whereName($value)
 * @method static whereContent($value)
 * @method static whereDisabled($value)
 */
class Meta extends Model
{
    protected $table = 'meta';

    protected $fillable = ['name', 'content', 'disabled'];

    public $translatable = [];

    public $timestamps = false;

    public static function toggleDisabled(int $id)
    {
        if ($item = self::find($id)) {
            $item->update(['disabled' => !$item->disabled]);
            $answer = json_encode(['success' => true, 'disabled' => $item->disabled]);
        }

        return $answer ?? json_encode(['success' => false]);
    }
}
