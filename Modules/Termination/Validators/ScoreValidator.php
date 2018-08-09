<?php

namespace Modules\Termination\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ScoreValidator.
 *
 * @package namespace App\Validators;
 */
class ScoreValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'attendant_id' => 'required | unique:termination_scores',
            'score' => 'required',
            'rp_last_action' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'attendant_id' => 'required',
            'score' => 'required',
            'rp_last_action' => 'required'
        ],
    ];

    protected $attributeNames = [
        'attendant_id' => 'Nome do atendente',
        'score' => 'Score',
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
