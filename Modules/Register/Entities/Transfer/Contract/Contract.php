<?php

namespace Modules\Register\Entities\Transfer\Contract;

use Illuminate\Database\Eloquent\Model;
use Modules\Register\Entities\Transfer\Reason\Reason;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Contract.
 *
 * @package namespace App\Entities;
 */
class Contract extends Model implements Transformable
{
    protected $table = 'register_transfer_contracts';

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'contract',
        'immobile_code',
        'address',
        'neighborhood',
        'value',
        'owner',
        'owner_phone_residential',
        'owner_phone_commercial',
        'owner_cell_phone',
        'owner_email',
        'requester_name',
        'requester_phone_01',
        'requester_phone_02',
        'requester_phone_03',
        'requester_email',
        'transfer_date',
        'status',
        'new_contract',
        'end_process',
        'reason_id',
        'responsible_transfer_id',
        'observation',
        'rp_last_action',
        'updated_at',
        'created_at',
    ];


    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = toLowerCase(removeAccents(trim($value)));
    }

    public function getAddressAttribute($value)
    {
        return uppercase($value);
    }

    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = toLowerCase(removeAccents(trim($value)));
    }

    public function getNeighborhoodAttribute($value)
    {
        return uppercase($value);
    }

    public function setOwnerAttribute($value)
    {
        $this->attributes['owner'] = toLowerCase(removeAccents(trim($value)));
    }

    public function getOwnerAttribute($value)
    {
        return uppercase($value);
    }

    public function setOwnerPhoneResidentialAttribute($value)
    {
        $this->attributes['owner_phone_residential'] = onlyNumber($value);
    }

    public function getOwnerPhoneResidentialAttribute($value)
    {
        return format_phone($value);
    }

    public function setOwnerPhoneCommercialAttribute($value)
    {
        $this->attributes['owner_phone_commercial'] = onlyNumber($value);
    }

    public function getOwnerPhoneCommercialAttribute($value)
    {
        return format_phone($value);
    }

    public function setOwnerCellPhoneAttribute($value)
    {
        $this->attributes['owner_cell_phone'] = onlyNumber($value);
    }

    public function getOwnerCellPhoneAttribute($value)
    {
        return format_phone($value);
    }

    public function setRequesterNameAttribute($value)
    {
        $this->attributes['requester_name'] = toLowerCase(removeAccents(trim($value)));
    }

    public function getRequesterNameAttribute($value)
    {
        return uppercase($value);
    }

    public function setRequesterPhone01Attribute($value)
    {
        $this->attributes['requester_phone_01'] = onlyNumber($value);
    }

    public function getRequesterPhone01Attribute($value)
    {
        return format_phone($value);
    }

    public function setRequesterPhone02Attribute($value)
    {
        $this->attributes['requester_phone_02'] = onlyNumber($value);
    }

    public function getRequesterPhone02Attribute($value)
    {
        return format_phone($value);
    }

    public function setRequesterPhone03Attribute($value)
    {
        $this->attributes['requester_phone_03'] = onlyNumber($value);
    }

    public function getRequesterPhone03Attribute($value)
    {
        return format_phone($value);
    }

    public function getValueAttribute($value)
    {
        return (float) $value;
    }

    public function setTransferDateAttribute($value)
    {
        $date = str_replace('/', '-', $value);
        $this->attributes['transfer_date'] = date('Y-m-d', strtotime($date));
    }

    public function setEndProcessAttribute($value)
    {
        if ($value) {
            $date = str_replace('/', '-', $value);
            $this->attributes['end_process'] = date('Y-m-d', strtotime($date));
        } else {
            $this->attributes['end_process'] = null;
        }
    }

    public function getReasonData()
    {
        return $this->hasOne(Reason::class, 'id', 'reason_id');
    }

    public function getResponsibleTransferData()
    {
        return $this->hasOne(User::class, 'id', 'responsible_transfer_id');
    }

}
