<?php

namespace Modules\Chat\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Message.
 *
 * @package namespace App\Entities;
 */
class Message extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "chat_messages";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'message',
        'user_id_sender',
        'user_id_destination',
        'date_read'
    ];

}
