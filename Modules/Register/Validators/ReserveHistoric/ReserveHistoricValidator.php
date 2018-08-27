<?php

namespace Modules\Register\Validators\ReserveHistoric;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class HistoricValidator.
 *
 * @package namespace App\Validators;
 */
class ReserveHistoricValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'historic'=> 'required',
            'rp_last_action'=> 'required',
            'reserve_id'=> 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'historic'=> 'required',
            'rp_last_action'=> 'required',
            'reserve_id'=> 'required',
        ]
    ];

    protected $attributeNames = [
        'historic' => 'Histórico',
        'rp_last_action' => 'Responsável pela ação',
        'reserve_id' => 'Identificador da reserva'
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
