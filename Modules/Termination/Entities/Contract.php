<?php

namespace Modules\Termination\Entities;

use Illuminate\Database\Eloquent\Model;
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
    use TransformableTrait;

    protected $table = "termination_contracts";

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
        'tenant',
        'tenant_phone_residential',
        'tenant_phone_commercial',
        'tenant_cell_phone',
        'tenant_email',
        'immobile_type',
        'type_location',
        'status',
        'termination_date',
        'end_process',
        'type_register',
        'reason_id',
        'destination_id',
        'rent_again',
        'caveat',
        'surveyor_id',
        'survey_release',
        'rp_per_inactive',
        'rp_last_action',
        'tenant_email',
        'observation',
        'archive',
        'rp_register_sector',
        'new_contract_code',
        'release_immobile',
        'created_at',
        'updated_at'
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

    public function setTenantAttribute($value)
    {
        $this->attributes['tenant'] = toLowerCase(removeAccents(trim($value)));
    }

    public function getTenantAttribute($value)
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

    public function setImmobileTypeAttribute($value)
    {
        $this->attributes['immobile_type'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setTypeLocationAttribute($value)
    {
        $this->attributes['type_location'] = toLowerCase(removeAccents(trim($value)));
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

    public function setTenantPhoneResidentialAttribute($value)
    {
        $this->attributes['tenant_phone_residential'] = onlyNumber($value);
    }

    public function getTenantPhoneResidentialAttribute($value)
    {
        return format_phone($value);
    }

    public function setTenantPhoneCommercialAttribute($value)
    {
        $this->attributes['tenant_phone_commercial'] = onlyNumber($value);
    }

    public function getTenantPhoneCommercialAttribute($value)
    {
        return format_phone($value);
    }

    public function setTenantCellPhoneAttribute($value)
    {
        $this->attributes['tenant_cell_phone'] = onlyNumber($value);
    }

    public function getTenantCellPhoneAttribute($value)
    {
        return format_phone($value);
    }

    public function getValueAttribute($value)
    {
        return (float) $value;
    }

    public function setTerminationDateAttribute($value)
    {
        $date = str_replace('/', '-', $value);
        $this->attributes['termination_date'] = date('Y-m-d', strtotime($date));
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

    /**
     * Retorna dados do responsável pela ação
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getResponsiblePerInactivated()
    {
        return $this->hasOne(User::class, 'id', 'rp_per_inactive');
    }

    /**
     * Retorna dados do responsável pelo setor
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getResponsibleRegisterSector()
    {
        return $this->hasOne(User::class, 'id', 'rp_register_sector');
    }

    /**
     * Retorna o motivo
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getReasonData()
    {
        return $this->hasOne(DestinationOrReason::class, 'id', 'reason_id');
    }

    /**
     * Retorna o destino
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getDestinationData()
    {
        return $this->hasOne(DestinationOrReason::class, 'id', 'destination_id');
    }

    /*
    public function getReleaseKeyData()
    {
        return $this->hasOne(ImmobileReleaseTermination::class, 'id', 'release_immobile');
    }

    public function getArchiveData()
    {
        return $this->hasOne(DeadFile::class, 'termination_id', 'id');
    }
    */
}
