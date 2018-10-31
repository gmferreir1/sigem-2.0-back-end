<?php

namespace Modules\Register\Validators\ReserveContract;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ReserveContractValidator.
 *
 * @package namespace App\Validators;
 */
class ReserveContractValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'immobile_code'=> 'required',
            'address'=> 'required',
            'neighborhood'=> 'required',
            'value'=> 'required',
            'immobile_type'=> 'required',
            'date_reserve'=> 'required',
            'prevision'=> 'required',
            'situation'=> 'required',
            'client_name'=> 'required',
            'client_phone_01'=> 'required',
            'attendant_register_id'=> 'required',
            'attendant_reception_id'=> 'required',
            'rp_last_action'=> 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'immobile_code'=> 'required',
            'address'=> 'required',
            'neighborhood'=> 'required',
            'value'=> 'required',
            'immobile_type'=> 'required',
            'date_reserve'=> 'required',
            'prevision'=> 'required',
            'situation'=> 'required',
            'client_name'=> 'required',
            'client_phone_01'=> 'required',
            'attendant_register_id'=> 'required',
            'attendant_reception_id'=> 'required',
            'rp_last_action'=> 'required',
        ]
    ];

    protected $attributeNames = [
        'immobile_code' => 'Codigo imóvel',
        'address' => 'Endereço',
        'neighborhood' => 'Bairro',
        'value' => 'Valor',
        'immobile_type' => 'Tipo imóvel',
        'date_reserve' => 'Data da reserva',
        'prevision' => 'Previsão da reserva',
        'situation' => 'Situação da reserva',
        'client_name' => 'Nome do cliente',
        'client_phone_01' => 'Telefone do cliente',
        'attendant_register_id' => 'Atendente do cadastro',
        'attendant_reception_id' => 'Atendente da recepção',
        'rp_last_action' => 'Responsável pela ação',
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
