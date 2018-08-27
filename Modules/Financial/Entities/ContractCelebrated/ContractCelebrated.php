<?php

namespace Modules\Financial\Entities\ContractCelebrated;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ContractCelebrated.
 *
 * @package namespace App\Entities;
 */
class ContractCelebrated extends Model implements Transformable
{
    use TransformableTrait;


    protected $table = "financial_contract_celebrateds";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'reserve_id',
        'contract',
        'immobile_code',
        'address',
        'neighborhood',
        'owner_name',
        'conclusion',
        'type_contract',
        'ticket',
        'tx_contract',
        'bank_expense',
        'subscription_iptu',
        'period_contract',
        'delivery_key',
        'rp_last_action',
        'status',
        'status_iptu',
        'status_tcrs',
        'due_date_rent',
        'loyalty_discount',
        'sync',
        'rp_release',
        'created_at',
        'updated_at',
    ];

    public function setContractAttribute($value)
    {
        $this->attributes['contract'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setImmobileCodeAttribute($value)
    {
        $this->attributes['immobile_code'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setOwnerNameAttribute($value)
    {
        $this->attributes['owner_name'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setConclusionAttribute($value)
    {
        if ($value) {
            $date = str_replace('/', '-', $value);
            $this->attributes['conclusion'] = date('Y-m-d', strtotime($date));
        } else {
            $this->attributes['conclusion'] = null;
        }
    }

    public function setDeliveryKeyAttribute($value)
    {
        if ($value) {
            $date = str_replace('/', '-', $value);
            $this->attributes['delivery_key'] = date('Y-m-d', strtotime($date));
        } else {
            $this->attributes['delivery_key'] = null;
        }
    }

    public function setDueDateRentAttribute($value)
    {
        if ($value) {
            $date = str_replace('/', '-', $value);
            $this->attributes['due_date_rent'] = date('Y-m-d', strtotime($date));
        } else {
            $this->attributes['due_date_rent'] = null;
        }
    }

    /**
     * Retorna os dados dos responsáveis pela reserva
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getRpReleaseData()
    {
        return $this->hasOne(User::class, 'id', 'rp_release');
    }

}
