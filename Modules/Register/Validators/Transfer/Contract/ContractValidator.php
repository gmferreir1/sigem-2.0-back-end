<?php

namespace Modules\Register\Validators\Transfer\Contract;

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
            'owner' => 'required',
            'requester_name' => 'required',
            'requester_phone_01' => 'required',
            'transfer_date' => 'required',
            'reason_id' => 'required',
            'responsible_transfer_id' => 'required',
            'rp_last_action' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'contract' => 'required',
            'immobile_code' => 'required',
            'address' => 'required',
            'neighborhood' => 'required',
            'value' => 'required',
            'owner' => 'required',
            'requester_name' => 'required',
            'requester_phone_01' => 'required',
            'transfer_date' => 'required',
            'reason_id' => 'required',
            'responsible_transfer_id' => 'required',
            'rp_last_action' => 'required',
        ],
    ];

    protected $attributeNames = [
        'contract' => 'Contrato',
        'immobile_code' => 'Código do imóvel',
        'address' => 'Endereço',
        'neighborhood' => 'Bairro',
        'value' => 'Valor',
        'owner' => 'Proprietário',
        'requester' => 'Solicitante',
        'requester_phone_01' => 'Telefone solicitante',
        'transfer_date' => 'Data da transferência',
        'reason_id' => 'Motivo',
        'responsible_transfer_id' => 'Responsável',
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
