<?php

namespace Modules\Register\Entities\ReserveHistoric;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Historic.
 *
 * @package namespace App\Entities;
 */
class ReserveHistoric extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "register_reserve_historics";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'historic',
        'rp_last_action',
        'reserve_id',
        'created_at',
        'updated_at',
    ];

    public function getRpLastActionData()
    {
        return $this->hasOne(User::class, 'id', 'rp_last_action');
    }
}
