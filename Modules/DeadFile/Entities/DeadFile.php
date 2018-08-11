<?php

namespace Modules\DeadFile\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class DeadFile.
 *
 * @package namespace App\Entities;
 */
class DeadFile extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'termination_id',
        'contract',
        'termination_date',
        'cashier',
        'file',
        'type_release',
        'status',
        'rp_last_action',
        'year_release',
        'created_at',
        'updated_at'
    ];

    public function getRpLastActionData()
    {
        return $this->hasOne(User::class, 'id', 'rp_last_action');
    }

}
