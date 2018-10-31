<?php

namespace Modules\ManagerAction\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ActionDatabase.
 *
 * @package namespace App\Entities;
 */
class ActionDatabase extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'manager_actions_database_updates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'table_name',
        'rp_action',
        'status'
    ];


    public function setTableNameAttribute($value)
    {
        $this->attributes['table_name'] = trim(removeAccents(strtolower($value)));
    }

    public function getRpActionData()
    {
        return $this->hasOne(User::class, 'id', 'rp_action');
    }

}
