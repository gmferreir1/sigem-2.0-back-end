<?php

namespace Modules\Register\Entities\ScoreAttendance;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ScoreAttendance.
 *
 * @package namespace App\Entities;
 */
class ScoreAttendance extends Model implements Transformable
{
    protected $table = "register_reserve_score_attendances";

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'id',
        'attendant_id',
        'score',
        'rp_last_action'
    ];

    public function setAttendantIdAttribute($value)
    {
        $this->attributes['attendant_id'] = (int) $value;
    }

    public function setScoreAttribute($value)
    {
        $this->attributes['score'] = (int) $value;
    }

    public function getAttendanceData()
    {
        return $this->hasOne(User::class, 'id', 'attendant_id');
    }

}
