<?php

namespace Modules\Sicadi\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class TenantAllContract extends Model implements Transformable
{
    use TransformableTrait;

    protected $connection = "sicadi";

    protected $table = "tenant_all_contracts";

    public $timestamps = false;

    protected $fillable = [
        'client_id_sicadi',
        'contract_id',
        'client_name',
        'client_code',
        'contract_code',
        'immobile_id',
    ];

    public function setClientIdSicadiAttribute($value)
    {
        $this->attributes['client_id_sicadi'] = trim($value);
    }

    public function setContractIdAttribute($value)
    {
        $this->attributes['contract_id'] = trim($value);
    }

    public function setClientNameAttribute($value)
    {
        $this->attributes['client_name'] = toLowerCase(removeAccents(encode($value)));
    }

    public function setClientCodeAttribute($value)
    {
        $this->attributes['client_code'] = trim($value);
    }

    public function setContractCodeAttribute($value)
    {
        $this->attributes['contract_code'] = trim($value);
    }

    public function setImmobileIdAttribute($value)
    {
        $this->attributes['immobile_id'] = trim($value);
    }

    public function getAddress()
    {
        return $this->hasOne(Address::class, 'client_id', 'client_id_sicadi')->limit(1);
    }
}
