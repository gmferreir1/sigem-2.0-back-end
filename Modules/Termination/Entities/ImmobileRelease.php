<?php

namespace Modules\Termination\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ImmobileRelease.
 *
 * @package namespace App\Entities;
 */
class ImmobileRelease extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "termination_immobile_releases";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'immobile_code',
        'inactivate_date',
        'rp_receive',
        'date_send',
        'site',
        'picture_site',
        'internal_picture',
        'observation',
        'advertisement',
        'termination_id',
        'rp_release',
        'rp_end_process',
        'status',
        'rp_last_action'
    ];

    public function setImmobileCodeAttribute($value)
    {
        $this->attributes['immobile_code'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setDateSendAttribute($value)
    {
        $date = str_replace('/', '-', $value);
        $this->attributes['date_send'] = date('Y-m-d', strtotime($date));
    }

    public function setInactivateDateAttribute($value)
    {
        $date = str_replace('/', '-', $value);
        $this->attributes['inactivate_date'] = date('Y-m-d', strtotime($date));
    }

    public function setAdvertisementAttribute($value)
    {
        if ($value) {
            $date = str_replace('/', '-', $value);
            $this->attributes['advertisement'] = date('Y-m-d', strtotime($date));
        } else {
            $this->attributes['advertisement'] = null;
        }
    }

    /**
     * Dados de quem vai receber as chaves
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getRpReceiveData()
    {
        return $this->hasOne(User::class, 'id', 'rp_receive');
    }
}
