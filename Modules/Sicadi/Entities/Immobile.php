<?php

namespace Modules\Sicadi\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Immobile extends Model implements Transformable
{
    protected $table = "immobiles";

    protected $connection = "sicadi";

    public $timestamps = false;

    use TransformableTrait;

    protected $fillable = [
        'immobile_id',
        'immobile_code',
        'address',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'building_name',
        'condominium_name',
        'condominium_id',
        'condominium_address',
        'condominium_syndicate',
        'condominium_neighborhood',
        'condominium_city',
        'condominium_state',
        'condominium_cep',
        'condominium_email',
        'type_immobile_id',
        'value_rent',
        'available_rental',
        'rent',
        'owner_code',
        'type_immobile',
        'type_occupation',
        'survey_observation',
        'iptu',
    ];


    public function setImmobileIdAttribute($value)
    {
        $this->attributes['immobile_id'] = trim($value);
    }

    public function setImmobileCodeAttribute($value)
    {
        $this->attributes['immobile_code'] = trim($value);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = $this->configAttribute($value);
    }

    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = $this->configAttribute($value);
    }

    public function setCityAttribute($value)
    {
        $this->attributes['city'] = $this->configAttribute($value);
    }

    public function setStateAttribute($value)
    {
        $this->attributes['state'] = $this->configAttribute($value);
    }

    public function setZipCodeAttribute($value)
    {
        $this->attributes['zip_code'] = $this->configAttribute($value);
    }

    public function setBuildingNameAttribute($value)
    {
        $this->attributes['building_name'] = $this->configAttribute($value);
    }

    public function setTypeImmobileIdAttribute($value)
    {
        $this->attributes['type_immobile_id'] = $this->configAttribute($value);
    }

    public function setCondominiumNameAttribute($value)
    {
        $this->attributes['condominium_name'] = $this->configAttribute($value);
    }

    public function setCondominiumAddressAttribute($value)
    {
        $this->attributes['condominium_address'] = $this->configAttribute($value);
    }

    public function setCondominiumSyndicateAttribute($value)
    {
        $this->attributes['condominium_syndicate'] = $this->configAttribute($value);
    }

    public function setCondominiumNeighborhoodAttribute($value)
    {
        $this->attributes['condominium_neighborhood'] = $this->configAttribute($value);
    }

    public function setCondominiumCityAttribute($value)
    {
        $this->attributes['condominium_city'] = $this->configAttribute($value);
    }

    public function setCondominiumStateAttribute($value)
    {
        $this->attributes['condominium_state'] = $this->configAttribute($value);
    }

    public function setValueRentAttribute($value)
    {
        $this->attributes['value_rent'] = $this->configAttribute($value);
    }

    public function setAvailableRentalAttribute($value)
    {
        $this->attributes['available_rental'] = $this->configAttribute($value);
    }

    public function setRentAttribute($value)
    {
        $this->attributes['rent'] = $this->configAttribute($value);
    }

    public function setOwnerCodeAttribute($value)
    {
        $this->attributes['owner_code'] = $this->configAttribute($value);
    }

    public function setTypeImmobileAttribute($value)
    {
        $this->attributes['type_immobile'] = $this->configAttribute($value);
    }

    public function setTypeOccupationAttribute($value)
    {
        $this->attributes['type_occupation'] = $this->configAttribute($value);
    }

    public function setSurveyObservationAttribute($value)
    {
        $this->attributes['survey_observation'] = $this->configAttribute($value);
    }

    public function getValueRentAttribute($value)
    {
        return (float) $value;
    }

    /**
     * @param $value
     * @return null|string
     */
    private function configAttribute($value)
    {
        return $value != null ? trim(removeAccents(toLowerCase(encode($value)))) : null;
    }

}
