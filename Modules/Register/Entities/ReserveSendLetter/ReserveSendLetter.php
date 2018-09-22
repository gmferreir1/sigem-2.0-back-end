<?php

namespace Modules\Register\Entities\ReserveSendLetter;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ReserveSendLetter.
 *
 * @package namespace App\Entities;
 */
class ReserveSendLetter extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "register_reserve_send_letters";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'letter_name',
        'reserve_id',
        'rp_last_action',
        'updated_at',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getRpLastActionData()
    {
        return $this->hasOne(User::class, 'id', 'rp_last_action');
    }
}
