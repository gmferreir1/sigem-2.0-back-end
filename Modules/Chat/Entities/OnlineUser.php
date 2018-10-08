<?php

namespace Modules\Chat\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OnlineUser.
 *
 * @package namespace App\Entities;
 */
class OnlineUser extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "chat_online_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'last_interaction',
        'online'
    ];

}
