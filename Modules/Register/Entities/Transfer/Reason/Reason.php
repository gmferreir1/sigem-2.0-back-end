<?php

namespace Modules\Register\Entities\Transfer\Reason;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Reason.
 *
 * @package namespace App\Entities;
 */
class Reason extends Model implements Transformable
{
    protected $table = "register_transfer_reasons";

    use TransformableTrait;

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
