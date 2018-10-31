<?php

namespace Modules\SystemAlert\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SystemAlert.
 *
 * @package namespace App\Entities;
 */
class SystemAlert extends Model implements Transformable
{

    protected $table = "system_alert";

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'message',
        'read',
        'responsible'
    ];

    public function setMessageAttribute($value)
    {
        $this->attributes['message'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setReadAttribute($value)
    {
        $this->attributes['read'] = (boolean) $value;
    }
}
