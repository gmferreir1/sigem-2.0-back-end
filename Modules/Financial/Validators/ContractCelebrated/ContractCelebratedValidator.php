<?php

namespace Modules\Validators\ContractCelebrated;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ContractCelebratedValidator.
 *
 * @package namespace App\Validators;
 */
class ContractCelebratedValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'reserve_id' => 'required|unique:financial_contract_celebrateds',
            'contract' => 'required|unique:financial_contract_celebrateds',
            'immobile_code' => 'required',
            'address' => 'required',
            'neighborhood' => 'required',
            'owner_name' => 'required',
            'conclusion' => 'required',
            'type_contract' => 'required',
            'ticket' => 'required',
            'tx_contract' => 'required',
            'bank_expense' => 'required',
            'period_contract' => 'required',
            'delivery_key' => 'required',
            'rp_last_action' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'reserve_id' => 'required',
            'contract' => 'required',
            'immobile_code' => 'required',
            'address' => 'required',
            'neighborhood' => 'required',
            'owner_name' => 'required',
            'conclusion' => 'required',
            'type_contract' => 'required',
            'ticket' => 'required',
            'tx_contract' => 'required',
            'bank_expense' => 'required',
            'period_contract' => 'required',
            'delivery_key' => 'required',
            'rp_last_action' => 'required',
            'status' => 'required'
        ]
    ];

    protected $attributeNames = [
        'reserve_id' => 'Identificador da reserva',
        'contract' => 'Contrato',
        'immobile_code' => 'Código imóvel',
        'address' => 'Endereço',
        'neighborhood' => 'Bairro',
        'owner_name' => 'Nome do proprietário',
        'conclusion' => 'Data da conclusão da reserva',
        'type_contract' => 'Tipo de contrato',
        'ticket' => 'Boleto',
        'tx_contract' => 'Taxa de contrato',
        'bank_expense' => 'Despesa do banco',
        'iptu' => 'IPTU',
        'tcrs' => 'TCRS',
        'period_contract' => 'Período contrato',
        'date_delivery_key' => 'Data da entrega das chaves',
        'rp_last_action' => 'Responsável pela ação',
        'status' => 'Status'
    ];


    /**
     * Pass the data and the rules to the validator
     *
     * @param string $action
     * @return bool
     */
    public function passes($action = null)
    {
        $rules = $this->getRules($action);
        $validator = $this->validator->make($this->data, $rules);
        $validator->setAttributeNames($this->attributeNames);

        if ($validator->fails()) {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }
}
