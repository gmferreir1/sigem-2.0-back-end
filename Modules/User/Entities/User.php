<?php

namespace Modules\User\Entities;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User.
 *
 * @package namespace Enjoy\Entities\Auth;
 */
class User extends Authenticatable implements Transformable
{
    use TransformableTrait, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'type_profile',
        'password',
        'status',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim(removeAccents(strtolower($value)));
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = trim(removeAccents(strtolower($value)));
    }

    public function setTypeProfileAttribute($value)
    {
        $this->attributes['type_profile'] = trim(removeAccents(strtolower($value)));
    }

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
