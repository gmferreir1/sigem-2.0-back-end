<?php

namespace Modules\Sicadi\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ImmobileVisit extends Model implements Transformable
{
    protected $connection = "sicadi";

    protected $table = "immobile_visits";

    public $timestamps = false;

    use TransformableTrait;

    protected $fillable = [
        'immobile_id',
        'immobile_code',
        'address',
        'neighborhood',
        'building_name',
        'condominium_name',
        'type_immobile_id',
        'value_rent',
        'available_rental',
        'rent',
        'type_immobile',
        'visit_id',
        'commentary',
        'type_visit',
        'visit_reserve',
        'date',
    ];

    public function setImmobileCodeAttribute($value)
    {
        $this->attributes['immobile_code'] = $this->trimAttribute($value);
    }

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

    public function setValueRentAttribute($value)
    {
        $this->attributes['value_rent'] = $value == null ? null : $value;
    }

    public function setAvailableRentalAttribute($value)
    {
        $this->attributes['available_rental'] = toLowerCase($value);
    }

    public function setRentAttribute($value)
    {
        $this->attributes['rent'] = $value == null ? null : toLowerCase($value);
    }

    public function setTypeImmobileAttribute($value)
    {
        $this->attributes['type_immobile'] = $this->checkAttribute($value);
    }

    public function setCommentaryAttribute($value)
    {
        $this->attributes['commentary'] = $this->checkAttribute($value);
    }

    public function setTypeVisitAttribute($value)
    {
        $this->attributes['type_visit'] = $this->checkAttribute($value);
    }

    public function setVisitReserveAttribute($value)
    {
        $this->attributes['visit_reserve'] = $this->checkAttribute($value);
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value == null ? null: substr($value, 0,10);
    }

    public function getValueRentAttribute($value)
    {
        return (float)$value;
    }

    public function getDateAttribute($value)
    {
        if($value)
        return Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    /**
     * @param $value
     * @return null|string
     */
    private function trimAttribute($value)
    {
        return $value == null ? null : trim($value);
    }

    private function checkAttribute($value)
    {
        return $value != null ? trim(removeAccents(toLowerCase(encode($value)))) : null;
    }

    public function clientVisit()
    {
        return $this->hasOne(Visit::class, 'visit_id', 'visit_id');
    }
}
