<?php

namespace Modules\Termination\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Score.
 *
 * @package namespace App\Entities;
 */
class Score extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "termination_scores";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attendant_id',
        'score',
        'rp_last_action',
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getAttendantData()
    {
        return $this->hasOne(User::class, 'id', 'attendant_id');
    }
}
