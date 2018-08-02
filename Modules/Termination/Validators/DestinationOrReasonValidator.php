<?php

namespace Modules\Termination\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class DestinationOrReasonValidator.
 *
 * @package namespace App\Validators;
 */
class DestinationOrReasonValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'type' => 'required',
            'text' => 'required',
            'rp_last_action' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'type' => 'required',
            'text' => 'required',
            'rp_last_action' => 'required'
        ],
    ];

    protected $attributeNames = [
        'type' => 'Tipo',
        'text' => 'Texto',
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
