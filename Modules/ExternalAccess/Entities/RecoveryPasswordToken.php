<?php

namespace Modules\ExternalAccess\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class RecoveryPasswordToken.
 *
 * @package namespace App\Entities;
 */
class RecoveryPasswordToken extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "recovery_password_tokens";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'token',
        'expired'
    ];
}
