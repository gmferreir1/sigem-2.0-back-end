<?php

namespace Modules\Register\Validators\ScoreAttendance;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ScoreAttendanceValidator.
 *
 * @package namespace App\Validators;
 */
class ScoreAttendanceValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'attendant_id' => 'required | unique:register_reserve_score_attendances',
            'score' => 'required',
            'rp_last_action' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'attendant_id' => 'required',
            'score' => 'required',
            'rp_last_action' => 'required',
        ],
    ];

    protected $attributeNames = [
        'attendant_id' => 'Código do atendente',
        'score' => 'Score',
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
