<?php

namespace Modules\SystemGoal\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class SystemGoalValidator.
 *
 * @package namespace App\Validators;
 */
class SystemGoalValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
            'type' => 'required',
            'rp_last_action' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required',
            'type' => 'required',
            'rp_last_action' => 'required'
        ],
    ];

    protected $attributeNames = [
        'name' => 'Nome',
        'text' => 'Tipo',
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
