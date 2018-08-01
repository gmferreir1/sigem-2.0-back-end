<?php

namespace Modules\Sicadi\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SReceiptTenantComplete.
 *
 * @package namespace App\Entities;
 */
class ReceiptTenantComplete extends Model implements Transformable
{

    protected $table = "receipt_tenant_completes";

    protected $connection = "sicadi";

    public $timestamps = false;

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receipt_tenant_id',
        'due_date',
        'payment_date',
        'value',
        'value_base',
        'value_pay',
        'month_serie',
        'value_rent',
        'contract_id'
    ];

    public function setDueDateAttribute($value)
    {
        $date = str_replace('/', '-', $value);
        $this->attributes['due_date'] = date('Y-m-d', strtotime($date));
    }

    public function setPaymentDateAttribute($value)
    {
        if ($value) {
            $date = str_replace('/', '-', $value);
            $this->attributes['payment_date'] = date('Y-m-d', strtotime($date));
        } else {
            $this->attributes['payment_date'] = null;
        }
    }

    public function setValueBaseAttribute($value)
    {
        if ($value) {
            $this->attributes['value_base'] = (float) $value;
        } else {
            $this->attributes['value_base'] = null;
        }
    }

    public function setValueRentAttribute($value)
    {
        if ($value) {
            $this->attributes['value_rent'] = (float) $value;
        } else {
            $this->attributes['value_rent'] = null;
        }
    }

    public function setValuePayAttribute($value)
    {
        if ($value) {
            $this->attributes['value_pay'] = (float) $value;
        } else {
            $this->attributes['value_pay'] = null;
        }
    }

    public function getValueAttribute($value)
    {
        return (float) $value;
    }

    public function getValueBaseAttribute($value)
    {
        return (float) $value;
    }

    public function getValuePayAttribute($value)
    {
        return (float) $value;
    }

    public function getValueReceiptAttribute($value)
    {
        return (float) $value;
    }

}
