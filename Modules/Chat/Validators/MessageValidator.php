<?php

namespace Modules\Chat\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class MessageValidator.
 *
 * @package namespace App\Validators;
 */
class MessageValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'message' => 'required',
            'user_id_sender' => 'required',
            'user_id_destination' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
        ],
    ];

    protected $attributeNames = [
        'message' => 'Mensagem',
        'user_id_sender' => 'Usuário de envio',
        'user_id_destination' => 'Usuário de destino',
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
