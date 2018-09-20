<?php

namespace Modules\ControlLetter\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ControlLetter.
 *
 * @package namespace App\Entities;
 */
class ControlLetter extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'text',
        'rp_last_action'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = toLowerCase(removeAccents(trim($value)));
    }
}
