<?php

namespace App;

use App\Helpers\TableProperties;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 * @package App
 *
 * @property integer $id
 * @property string $phone
 * @property string $address
 * @property string $email
 * @property string $map_lat
 * @property string $map_lng
 * @property string $map_link
 * @property string $social_networks
 * @property string $description
 *
 * @method static whereId($value)
 * @method static wherePhone($value)
 * @method static whereAddress($value)
 * @method static whereEmail($value)
 * @method static whereMapLat($value)
 * @method static whereMapLng($value)
 * @method static whereMapLink($value)
 * @method static whereSocialNetworks($value)
 * @method static whereDescription($value)
 */
class Contact extends Model
{
    use TableProperties;

    public $timestamps = false;

    public $translatable = [
        'address',
        'social_networks',
        'description',
    ];

    protected $guarded = [];
}
