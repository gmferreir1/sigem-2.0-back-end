<?php

namespace Modules\ControlLetter\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ControlLetterValidator.
 *
 * @package namespace App\Validators;
 */
class ControlLetterValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
            'text' => 'required',
            'rp_last_action' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required',
            'text' => 'required',
            'rp_last_action' => 'required'
        ],
    ];

    protected $attributeNames = [
        'name' => 'Nome',
        'text' => 'Texto carta',
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
