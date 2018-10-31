<?php

namespace Modules\ImmobileCaptured\Entities\ReportList;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Sicadi\Entities\ImmobileType;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ReportList.
 *
 * @package namespace App\Entities;
 */
class ReportList extends Model implements Transformable
{

    protected $table = "immobile_captured_report_lists";

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'immobile_code',
        'address',
        'neighborhood',
        'value',
        'owner',
        'type_immobile',
        'type_location',
        'captured_date',
        'responsible',
        'rp_last_action',
        'created_at',
        'updated_at',
    ];


    public function setImmobileCodeAttribute($value)
    {
        $this->attributes['immobile_code'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = (float) $value;
    }

    public function setOwnerAttribute($value)
    {
        $this->attributes['owner'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setTypeLocationAttribute($value)
    {
        $this->attributes['type_location'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setCapturedDateAttribute($value)
    {
        $date = str_replace('/', '-', $value);
        $this->attributes['captured_date'] = date('Y-m-d', strtotime($date));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getTypeImmobile()
    {
        return $this->hasOne(ImmobileType::class, 'type_immobile_id', 'type_immobile');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getResponsibleData()
    {
        return $this->hasOne(User::class, 'id', 'responsible');
    }

}
