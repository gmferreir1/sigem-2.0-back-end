<?php

namespace Modules\Termination\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class RentAccessory.
 *
 * @package namespace App\Entities;
 */
class RentAccessory extends Model implements Transformable
{
    protected $table = "termination_rent_accessories";

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'fine_termination',
        'fine_termination_type_debit',
        'fine_termination_value_debit',

        'condominium',
        'condominium_type_debit',
        'condominium_value_debit',

        'copasa',
        'copasa_value_debit',

        'cemig',
        'cemig_value_debit',

        'iptu',
        'iptu_type_debit',
        'iptu_value_debit',

        'garbage_rate',
        'garbage_rate_type_debit',
        'garbage_rate_value_debit',

        'pendencies',
        'pendencies_type_debit',
        'pendencies_value_debit',

        'paint',
        'paint_type_debit',
        'paint_value_debit',

        'value_rent',
        'value_rent_type_debit',
        'value_rent_value_debit',

        'keys_delivery',
        'control_gate',
        'control_alarm',
        'key_manual_gate',
        'fair_card',

        'new_address',
        'new_neighborhood',
        'new_city',
        'new_state',

        'termination_id',

        'rp_last_action',

        'created_at',
        'updated_at'
    ];

    public function getFineTerminationValueDebitAttribute($value)
    {
        return (float) $value;
    }

    public function getCondominiumValueDebitAttribute($value)
    {
        return (float) $value;
    }

    public function getCopasaValueDebitAttribute($value)
    {
        return (float) $value;
    }

    public function getCemigValueDebitAttribute($value)
    {
        return (float) $value;
    }

    public function getIptuValueDebitAttribute($value)
    {
        return (float) $value;
    }

    public function getGarbageRateValueDebitAttribute($value)
    {
        return (float) $value;
    }

    public function getPendenciesValueDebitAttribute($value)
    {
        return (float) $value;
    }

    public function getValueRentValueDebitAttribute($value)
    {
        return (float) $value;
    }

    public function getPaintValueDebitAttribute($value)
    {
        return (float) $value;
    }

}
