<?php

namespace Modules\Sicadi\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ClientContract extends Model implements Transformable
{
    protected $table = "client_contracts";

    protected $connection = "sicadi";

    public $timestamps = false;

    use TransformableTrait;

    protected $fillable = [
        'client_id',
        'contract_id',
        'type_client_contract',
        'main',
    ];

    public function setClientIdAttribute($value)
    {
        $this->attributes['client_id'] = (int) $value;
    }

    public function setContractIdAttribute($value)
    {
        $this->attributes['contract_id'] = (int) $value;
    }

    public function setTypeClientContractAttribute($value)
    {
        $this->attributes['type_client_contract'] = toLowerCase(trim($value));
    }

    public function setMainAttribute($value)
    {
        $this->attributes['main'] = toLowerCase(trim($value));
    }
}
