<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 * @package App
 *
 * @property integer $id
 * @property string $firstName
 * @property string $lastName
 * @property string $phone
 * @property string $email
 * @property string $description
 * @property string $status
 * @property integer $peopleCount
 * @property \DateTime $date_time
 *
 * @method static whereId($value)
 * @method static whereFirstName($value)
 * @method static whereLastName($value)
 * @method static wherePhone($value)
 * @method static whereEmail($value)
 * @method static whereDescription($value)
 * @method static whereStatus($value)
 * @method static wherePeopleCount($value)
 * @method static whereDateTime($value)
 */
class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'description', 'people_amount', 'status'];

    public $translatable = [];

    public function changeStatus($id, $status)
    {
        if ($item = self::find($id)) {
            $item->update(['status' => $status]);
            $answer = json_encode(['success' => true, 'status' => $item->status]);
        }

        return $answer ?? json_encode(['success' => false]);
    }
}
