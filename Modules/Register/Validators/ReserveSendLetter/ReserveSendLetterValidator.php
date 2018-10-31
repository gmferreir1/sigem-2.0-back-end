<?php

namespace Modules\Register\Validators\ReserveSendLetter;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ReserveSendLetterValidator.
 *
 * @package namespace App\Validators;
 */
class ReserveSendLetterValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'letter_name'=> 'required',
            'reserve_id'=> 'required',
            'rp_last_action'=> 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'letter_name'=> 'required',
            'reserve_id'=> 'required',
            'rp_last_action'=> 'required'
        ]
    ];

    protected $attributeNames = [
        'letter_name' => 'Nome da carta',
        'reserve_id' => 'Identificador da reserva',
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
