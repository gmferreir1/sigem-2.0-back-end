<?php

namespace Modules\Sicadi\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Visit extends Model implements Transformable
{
    protected $connection = "sicadi";

    protected $table = "visits";

    public $timestamps = false;

    use TransformableTrait;

    protected $fillable = [
        'visit_id',
        'client_name',
        'address',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'phone_commercial',
        'phone_residential',
        'cell_phone',
        'email',
        'date_register',
    ];

    public function setClientNameAttribute($value)
    {
        $this->attributes['client_name'] = toLowerCase(removeAccents(encode($value)));
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = $this->checkAttributeEncode($value);
    }

    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = $this->checkAttributeEncode($value);
    }

    public function setCityAttribute($value)
    {
        $this->attributes['city'] = $this->checkAttributeEncode($value);
    }

    public function setStateAttribute($value)
    {
        $this->attributes['state'] = $this->checkAttributeEncode($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $this->checkAttributeEncode($value);
    }

    public function setZipCodeAttribute($value)
    {
        $this->attributes['zip_code'] = $this->trimAttribute($value);
    }

    public function setPhoneCommercialAttribute($value)
    {
        $this->attributes['phone_commercial'] = $this->trimAttribute($value);
    }

    public function setPhoneResidentialAttribute($value)
    {
        $this->attributes['phone_residential'] = $this->trimAttribute($value);
    }

    public function setCellPhoneAttribute($value)
    {
        $this->attributes['cell_phone'] = $this->trimAttribute($value);
    }

    public function setDateRegisterAttribute($value)
    {
        $this->attributes['date_register'] = date('Y-m-d', strtotime($value));
    }


    /**
     * @param $value
     * @return null|string
     */
    private function trimAttribute($value)
    {
        return $value == null ? null : trim($value);
    }

    /**
     * @param $value
     * @return null|string
     */
    private function checkAttributeEncode($value)
    {
        return $value == null ? null : trim(encode($value));
    }
}
