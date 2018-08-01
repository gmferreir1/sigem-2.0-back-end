<?php

namespace Modules\Sicadi\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ReceiptTenant extends Model implements Transformable
{

    protected $table = "receipt_tenants";

    protected $connection = "sicadi";

    public $timestamps = false;

    use TransformableTrait;

    protected $fillable = [
        'payment_date',
        'maturity_date',
        'value_last_payment',
        'value_base',
        'contract_id',
    ];

    public function setValueLastPaymentAttribute($value)
    {
        $this->attributes['value_last_payment'] = (float) $value;
    }

    public function setValueBaseAttribute($value)
    {
        $this->attributes['value_base'] = (float) $value;
    }

    public function setContractIdAttribute($value)
    {
        $this->attributes['contract_id'] = (int) $value;
    }
}
