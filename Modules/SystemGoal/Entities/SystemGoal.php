<?php

namespace Modules\SystemGoal\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SystemGoal.
 *
 * @package namespace App\Entities;
 */
class SystemGoal extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'value',
        'percent',
        'sob_goal',
        'rp_last_action'
    ];


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim(removeAccents(strtolower($value)));
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = trim(removeAccents(strtolower($value)));
    }

    public function getRpLastActionData()
    {
        return $this->hasOne(User::class, 'id', 'rp_last_action');
    }

}
