<?php

namespace Modules\Sicadi\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Contract extends Model implements Transformable
{
    use TransformableTrait;

    protected $connection = "sicadi";

    protected $table = "contracts";

    public $timestamps = false;

    protected $fillable = [
        'contract_id',
        'tenant_name',
        'contract_code',
        'date_primary_contract',
        'init_date_current_contract',
        'contract_time',
        'value_rent',
        'immobile_id',
        'address',
        'neighborhood',
        'city',
        'building_name',
        'condominium_name',
        'type_immobile',
        'type_immobile_id',
        'termination_date',
        'last_adjustment',
    ];

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = $this->checkAttribute($value);
    }

    public function setContractCodeAttribute($value)
    {
        $this->attributes['contract_code'] = $this->checkAttribute($value);
    }

    public function setTenantNameAttribute($value)
    {
        $this->attributes['tenant_name'] = $this->checkAttribute($value);
    }

    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = $this->checkAttribute($value);
    }

    public function setCityAttribute($value)
    {
        $this->attributes['city'] = $this->checkAttribute($value);
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

    public function setTypeImmobileIdAttribute($value)
    {
        $this->attributes['type_immobile_id'] = $this->checkAttribute($value);
    }

    public function getValueRentAttribute($value)
    {
        return (float)$value;
    }

    public function getInitDateCurrentContractAttribute($value)
    {
        if($value)
            return Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    public function getDatePrimaryContractAttribute($value)
    {
        if($value)
            return Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    /**
     * @param $value
     * @return null|string
     */
    public function checkAttribute($value)
    {
        return $value != null ? trim(removeAccents(toLowerCase(encode($value)))) : null;
    }

    public function setTerminationDateAttribute($value)
    {

        if(!$value or $value == '') {
            $value = null;
        }

        $this->attributes['termination_date'] = $value;
    }

}
