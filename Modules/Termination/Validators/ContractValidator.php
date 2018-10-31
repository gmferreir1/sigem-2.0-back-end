<?php

namespace Modules\Termination\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ContractValidator.
 *
 * @package namespace App\Validators;
 */
class ContractValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'contract' => 'required',
            'immobile_code' => 'required',
            'address' => 'required',
            'neighborhood' => 'required',
            'value' => 'required',
            'tenant' => 'required',
            'immobile_type' => 'required',
            'type_location' => 'required',
            'rp_last_action' => 'required',
            'rp_per_inactive' => 'required',
            'termination_date' => 'required',
            'reason_id' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'contract' => 'required',
            'immobile_code' => 'required',
            'address' => 'required',
            'neighborhood' => 'required',
            'value' => 'required',
            'tenant' => 'required',
            'immobile_type' => 'required',
            'type_location' => 'required',
            'rp_last_action' => 'required',
            'rp_per_inactive' => 'required',
            'termination_date' => 'required',
            'reason_id' => 'required',
        ],
    ];

    protected $attributeNames = [
        'contract' => 'Contrato',
        'immobile_code' => 'Código do Imóvel',
        'address' => 'Endereço',
        'neighborhood' => 'Bairro',
        'value' => 'Valor',
        'tenant' => 'Inquilino',
        'immobile_type' => 'Tipo Imóvel',
        'type_location' => 'Tipo Locação',
        'termination_date' => 'Data da Inativação',
        'rp_per_inactive' => 'Responsável Inativação',
        'rp_last_action' => 'Responsável Pela Ação',
        'reason_id' => 'Motivo',
    ];

    /**
     * Pass the data and the rules to the validator
     *
     * @param string $action
     * @return bool
     */
    public function passes($action = null)
    {
        $rules     = $this->getRules($action);
        $validator = $this->validator->make($this->data, $rules);
        $validator->setAttributeNames($this->attributeNames);

        if( $validator->fails() )
        {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }
}
