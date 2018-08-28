<?php

namespace Modules\Register\Entities\Transfer\ScoreAttendant;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ScoreAttendant.
 *
 * @package namespace App\Entities;
 */
class ScoreAttendant extends Model implements Transformable
{
    protected $table = "register_transfer_score_attendants";

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attendant_id',
        'score',
        'rp_last_action'
    ];

    public function getAttendanceData()
    {
        return $this->hasOne(User::class, 'id', 'attendant_id');
    }

}
