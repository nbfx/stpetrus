<?php

namespace App;

use App\Helpers\TableProperties;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class Language
 * @package App
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $order
 *
 * @method static whereId($value)
 * @method static whereTitle($value)
 * @method static whereDescription($value)
 * @method static whereOrder($value)
 */
class Language extends Model
{
    use TableProperties;

    public $timestamps = false;

    protected $guarded = [];

    public $translatable = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model)
        {
            $translatableModels = config('multilanguage.translatable');
            foreach ($translatableModels as $translatableModel) {
                $translatableModelClass = new $translatableModel();
                $allColumns = $translatableModelClass->getTableColumns();
                $translatableColumns = $translatableModelClass->translatable;
                $table = $translatableModelClass->getTable();
                foreach ($translatableColumns as $translatableColumn) {
                    $newField = "{$translatableColumn}_$model->locale";
                    $type = $allColumns[$translatableColumn];
                    Schema::table($table, function (Blueprint $table) use ($newField, $type) {
                        $table->$type($newField)->nullable();
                    });
                }
            }
        });

        static::deleting(function($model) {
            $translatableModels = config('multilanguage.translatable');
            foreach ($translatableModels as $translatableModel) {
                $translatableModelClass = new $translatableModel();
                $allColumns = $translatableModelClass->getTableColumns();
                $translatableColumns = $translatableModelClass->translatable;
                $table = $translatableModelClass->getTable();
                foreach ($translatableColumns as $translatableColumn) {
                    $newField = "{$translatableColumn}_$model->locale";
                    $type = $allColumns[$translatableColumn];
                    if(Schema::hasColumn($table, $newField)) {
                        Schema::table($table, function (Blueprint $table) use ($newField, $type) {
                            $table->dropColumn($newField);
                        });
                    }
                }
            }
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
