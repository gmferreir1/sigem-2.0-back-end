<?php

namespace Modules\User\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UserValidator.
 *
 * @package namespace App\Validators;
 */
class UserValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'email' => 'required | unique:users',
            'name' => 'required',
            'last_name' => 'required',
            'status' => 'required',
            'type_profile' => 'required',
            'password' => 'required|confirmed|min:6'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required',
            'last_name' => 'required',
            'status' => 'required',
            'type_profile' => 'required'
        ],
    ];

    protected $attributeNames = [
        'name' => 'Nome',
        'last_name' => 'Sobrenome',
        'status' => 'Status',
        'type_profile' => 'Tipo de perfil',
        'password' => 'Senha'
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
