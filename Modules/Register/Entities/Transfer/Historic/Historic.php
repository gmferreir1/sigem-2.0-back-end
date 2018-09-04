<?php

namespace Modules\Register\Entities\Transfer\Historic;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Historic.
 *
 * @package namespace App\Entities;
 */
class Historic extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "register_transfer_historics";

    protected $fillable = [
        'id',
        'historic',
        'rp_last_action',
        'transfer_id',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function rpLastActionData()
    {
        return $this->hasOne(User::class, 'id', 'rp_last_action');
    }

}
