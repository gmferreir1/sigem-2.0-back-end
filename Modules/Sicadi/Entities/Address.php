<?php

namespace Modules\Sicadi\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Address.
 *
 * @package namespace App\Entities;
 */
class Address extends Model implements Transformable
{
    use TransformableTrait;

    protected $connection = "sicadi";

    protected $table = "addresses";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'address',
        'neighborhood',
        'city',
        'state',
        'zip_code',
    ];


    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = trimAndEncode($value);
    }

    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = trimAndEncode($value);
    }

    public function setCityAttribute($value)
    {
        $this->attributes['city'] = trimAndEncode($value);
    }

    public function setStateAttribute($value)
    {
        $this->attributes['state'] = trimAndEncode($value);
    }

    public function setZipCodeAttribute($value)
    {
        $this->attributes['zip_code'] =  onlyNumber($value);
    }



}
