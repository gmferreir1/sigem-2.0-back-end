<?php

namespace Modules\Sicadi\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class InactiveContract extends Model implements Transformable
{
    protected $connection = "sicadi";

    protected $table = "inactive_contracts";

    public $timestamps = false;

    use TransformableTrait;

    protected $fillable = [
        'contract_code',
        'date_primary_contract',
        'init_date_current_contract',
        'contract_time',
        'value_rent',
        'date_cancellation',
        'immobile_id',
        'address',
        'neighborhood',
        'city',
        'building_name',
        'condominium_name',
        'type_immobile',
        'type_immobile_id',
    ];

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = $this->checkAttribute($value);
    }

    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = $this->checkAttribute($value);
    }

    public function setBuildingNameAttribute($value)
    {
        $this->attributes['building_name'] = $this->checkAttribute($value);
    }

    public function setCondominiumNameAttribute($value)
    {
        $this->attributes['condominium_name'] = $this->checkAttribute($value);
    }

    public function setTypeImmobileAttribute($value)
    {
        $this->attributes['type_immobile'] = $this->checkAttribute($value);
    }

    public function setDateCancellationAttribute($value)
    {
        $this->attributes['date_cancellation'] = $value != null ? substr($value, 0,10) : null;
    }

    public function getValueRentAttribute($value)
    {
        return (float)$value;
    }


    private function checkAttribute($value)
    {
        return $value != null ? trim(removeAccents(toLowerCase(encode($value)))) : null;
    }
}
