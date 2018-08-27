<?php

namespace Modules\Register\Entities\ReserveContract;

use Illuminate\Database\Eloquent\Model;
use Modules\Register\Entities\ReserveReasonCancel\ReserveReasonCancel;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ReserveContract.
 *
 * @package namespace App\Entities;
 */
class ReserveContract extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "register_reserve_contracts";

    protected $fillable = [
        'id',
        'immobile_code',
        'address',
        'neighborhood',
        'value',
        'value_negotiated',
        'type_location',
        'immobile_type',
        'code_reserve',
        'year_reserve',
        'date_reserve',
        'prevision',
        'conclusion',
        'situation',
        'contract',
        'deadline',
        'taxa',
        'observation',
        'origin_city',
        'origin_state',
        'finality',
        'client_name',
        'client_rg',
        'client_cpf',
        'client_profession',
        'client_company',
        'client_address',
        'client_neighborhood',
        'client_city',
        'client_state',
        'client_phone_01',
        'client_phone_02',
        'client_phone_03',
        'client_email',
        'attendant_register_id',
        'attendant_reception_id',
        'email_owner',
        'email_tenant',
        'email_condominium',
        'rp_last_action',
        'id_reason_cancel',
        'reason_cancel_detail',
        'end_process',
        'created_at',
        'updated_at'
    ];

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = (float) $value;
    }

    public function setClientNameAttribute($value)
    {
        $this->attributes['client_name'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setClientCpfAttribute($value)
    {
        $this->attributes['client_cpf'] = onlyNumber($value);
    }

    public function setClientRgAttribute($value)
    {
        $this->attributes['client_rg'] = toLowerCase($value);
    }

    public function setClientProfessionAttribute($value)
    {
        $this->attributes['client_profession'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setClientCompanyAttribute($value)
    {
        $this->attributes['client_company'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setClientAddressAttribute($value)
    {
        $this->attributes['client_address'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setClientNeighborhoodAttribute($value)
    {
        $this->attributes['client_neighborhood'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setClientCityAttribute($value)
    {
        $this->attributes['client_city'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setClientStateAttribute($value)
    {
        $this->attributes['client_state'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setObservationAttribute($value)
    {
        $this->attributes['observation'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setFinalityAttribute($value)
    {
        $this->attributes['finality'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setOriginCityAttribute($value)
    {
        $this->attributes['origin_city'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setOriginStateAttribute($value)
    {
        $this->attributes['origin_state'] = toLowerCase(removeAccents(trim($value)));
    }

    public function setClientPhone01Attribute($value)
    {
        $this->attributes['client_phone_01'] = onlyNumber($value);
    }

    public function setClientPhone02Attribute($value)
    {
        $this->attributes['client_phone_02'] = onlyNumber($value);
    }

    public function setClientPhone03Attribute($value)
    {
        $this->attributes['client_phone_03'] = onlyNumber($value);
    }

    public function setDateReserveAttribute($value)
    {
        $date = str_replace('/', '-', $value);
        $this->attributes['date_reserve'] = date('Y-m-d', strtotime($date));
    }

    public function setPrevisionAttribute($value)
    {
        $date = str_replace('/', '-', $value);
        $this->attributes['prevision'] = date('Y-m-d', strtotime($date));
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

    public function getValueAttribute($value)
    {
        return (float) $value;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getAttendantRegisterData()
    {
        return $this->hasOne(User::class, 'id', 'attendant_register_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getAttendantReceptionData()
    {
        return $this->hasOne(User::class, 'id', 'attendant_reception_id');
    }

    /**
     * Retorna o motivo do cancelamento
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getReasonCancelData()
    {
        return $this->hasOne(ReserveReasonCancel::class, 'id', 'id_reason_cancel');
    }
}
