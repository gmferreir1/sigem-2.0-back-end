<?php

namespace Modules\Register\Entities\ReserveReasonCancel;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class RegisterReasonCancel.
 *
 * @package namespace App\Entities;
 */
class ReserveReasonCancel extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "register_reserve_reason_cancels";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reason',
        'rp_last_action'
    ];

    public function setReasonAttribute($value)
    {
        $this->attributes['reason'] = toLowerCase(removeAccents(trim($value)));
    }

}
