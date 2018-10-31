<?php

namespace Modules\ImmobileCaptured\Validators\ReportList;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ReportListValidator.
 *
 * @package namespace App\Validators;
 */
class ReportListValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'immobile_code' => 'required | unique:immobile_captured_report_lists',
            'address' => 'required',
            'neighborhood' => 'required',
            'value' => 'required',
            'owner' => 'required',
            'type_immobile' => 'required',
            'type_location' => 'required',
            'captured_date' => 'required',
            'responsible' => 'required',
            'rp_last_action' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'immobile_code' => 'required',
            'address' => 'required',
            'neighborhood' => 'required',
            'value' => 'required',
            'owner' => 'required',
            'type_immobile' => 'required',
            'type_location' => 'required',
            'captured_date' => 'required',
            'responsible' => 'required',
            'rp_last_action' => 'required'
        ]
    ];

    protected $attributeNames = [
        'immobile_code' => 'Código imóvel',
        'address' => 'Endereço',
        'neighborhood' => 'Bairro',
        'value' => 'Valor',
        'owner' => 'Nome do proprietário',
        'type_immobile' => 'Tipo imóvel',
        'type_location' => 'Tipo de locação',
        'captured_date' => 'Data captação',
        'responsible' => 'Responsável captação',
        'rp_last_action' => 'Responsável pela ação'
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
