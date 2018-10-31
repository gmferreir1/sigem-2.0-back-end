<?php

namespace Modules\Sicadi\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SPhone.
 *
 * @package namespace App\Entities;
 */
class Phone extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "phones";

    protected $connection = "sicadi";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'ddd',
        'phone',
        'type_phone',
        'main'
    ];

    public function setPhoneAttribute($value)
    {
        if ($value) {
            $this->attributes['phone'] = onlyNumber($value);
        }
    }

    public function setDddAttribute($value)
    {
        if ($value) {
            $this->attributes['ddd'] = ltrim($value, '0');
        }
    }

    public function setTypePhoneAttribute($value)
    {
        $this->attributes['type_phone'] = toLowerCase(trim($value));
    }

}
