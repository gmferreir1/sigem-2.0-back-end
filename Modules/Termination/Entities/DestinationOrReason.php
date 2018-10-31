<?php

namespace Modules\Termination\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class DestinationOrReason.
 *
 * @package namespace App\Entities;
 */
class DestinationOrReason extends Model implements Transformable
{
    protected $table = "termination_destination_or_reasons";

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'type',
        'text',
        'rp_last_action',
        'created_at',
        'updated_at'
    ];

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = trim(removeAccents(strtolower($value)));
    }

    public function setTextAttribute($value)
    {
        $this->attributes['text'] = trim(removeAccents(strtolower($value)));
    }

}
