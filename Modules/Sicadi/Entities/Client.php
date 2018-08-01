<?php

namespace Modules\Sicadi\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Client extends Model implements Transformable
{
    use TransformableTrait;

    protected $connection = "sicadi";

    protected $table = "clients";

    public $timestamps = false;

    protected $fillable = [
        'client_id_sicadi',
        'client_code',
        'client_name',

        'type_client',
        'birth_date',
        'sex',
        'civil_state',
        'rg',
        'mother_name',
        'father_name',
        'spouse_code',
        'company',
        'responsible_company',
        'cic_cgc',
        'email',
    ];


    public function setClientCodeAttribute($value)
    {
        $this->attributes['client_code'] = trim($value);
    }

    public function setClientNameAttribute($value)
    {
        $this->attributes['client_name'] = $this->checkAttributeEncode($value);
    }

    public function setTypeClient($value)
    {
        $this->attributes['type_client'] = (int) $value;
    }

    public function setMotherNameAttribute($value)
    {
        $this->attributes['mother_name'] = $this->checkAttributeEncode($value);
    }

    public function setFatherNameAttribute($value)
    {
        $this->attributes['father_name'] = $this->checkAttributeEncode($value);
    }

    public function setCompanyAttribute($value)
    {
        $this->attributes['company'] = $this->checkAttributeEncode($value);
    }

    public function setCivilStateAttribute($value)
    {
        $this->attributes['civil_state'] = $this->checkAttributeEncode($value);
    }

    public function setResponsibleCompanyAttribute($value)
    {
        $this->attributes['responsible_company'] = $this->checkAttributeEncode($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $this->checkAttributeEncode($value);
    }

    public function setCicCgcAttribute($value)
    {
        $this->attributes['cic_cgc'] = onlyNumber(trim($value));
    }

    public function getCicCgcAttribute($value)
    {
        return onlyNumber($value);
    }

    public function setSexAttribute($value)
    {
        $this->attributes['sex'] = $this->checkAttributeEncode($value);
    }

    public function getSexAttribute($value)
    {
        return $this->checkAttributeEncode($value);
    }

    /**
     * @param $value
     * @return null|string
     */
    private function checkAttributeEncode($value)
    {
        return $value != null ? trim(removeAccents(toLowerCase(encode($value)))) : null;
    }
}
