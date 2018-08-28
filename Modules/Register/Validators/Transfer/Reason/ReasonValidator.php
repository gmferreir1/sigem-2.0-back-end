<?php

namespace Modules\Register\Validators\Transfer\Reason;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ReasonValidator.
 *
 * @package namespace App\Validators;
 */
class ReasonValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'reason' => 'required | unique:register_transfer_reasons',
            'rp_last_action' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'reason' => 'required',
            'rp_last_action' => 'required',
        ],
    ];

    protected $attributeNames = [
        'reason' => 'Motivo',
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
