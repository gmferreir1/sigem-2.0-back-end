<?php

namespace Modules\Termination\Entities;

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

    protected $table = "termination_contract_historics";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contract_id',
        'historic',
        'rp_last_action',
        'type_action',
        'created_at',
        'updated_at',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getRpLastActionData ()
    {
        return $this->hasOne(User::class, 'id', 'rp_last_action');
    }

}
