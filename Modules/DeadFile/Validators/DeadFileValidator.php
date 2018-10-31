<?php

namespace Modules\DeadFile\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class DeadFileValidator.
 *
 * @package namespace App\Validators;
 */
class DeadFileValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'type_release' => 'required',
            'status' => 'required',
            'year_release' => 'required',
            'termination_date' => 'required',
            'termination_id' => 'required',
            'contract' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [],
    ];

    protected $attributeNames = [
        'type_release' => 'Tipo de lançamento',
        'status' => 'Status',
        'year_release' => 'Ano de lançamento',
        'termination_date' => 'Data da inativação',
        'termination_id' => 'Identificador da inativação',
        'contract' => 'Contrato',
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
