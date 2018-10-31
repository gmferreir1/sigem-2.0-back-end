<?php

namespace Modules\Chat\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class OnlineUserValidator.
 *
 * @package namespace App\Validators;
 */
class OnlineUserValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => 'required',
            'last_interaction' => 'required',
            'online' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
        ],
    ];

    protected $attributeNames = [
        'user_id' => 'Identificador do usuário',
        'last_interaction' => 'Ultima interação',
        'online' => 'Status usuário',
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
