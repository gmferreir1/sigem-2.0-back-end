<?php

namespace Modules\Termination\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ImmobileReleaseValidator.
 *
 * @package namespace App\Validators;
 */
class ImmobileReleaseValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'immobile_code' => 'required',
            'inactivate_date' => 'required',
            'rp_receive' => 'required',
            'date_send' => 'required',
            'termination_id' => 'required | unique:termination_immobile_releases',
            'rp_release' => 'required',
            'rp_last_action' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'immobile_code' => 'required',
            'inactivate_date' => 'required',
            'rp_receive' => 'required',
            'date_send' => 'required',
            'site' => 'required',
            'picture_site' => 'required',
            'internal_picture' => 'required',
            'advertisement' => 'required',
            'status' => 'required',
            'rp_last_action' => 'required',
        ],
    ];

    protected $attributeNames = [
        'immobile_code' => 'Código do Imóvel',
        'inactivate_date' => 'Data da Inativação',
        'rp_receive' => 'Responsável Entrega Chaves',
        'date_send' => 'Data de Repasse',
        'termination_id' => 'Identificador Inativação',
        'rp_release' => 'Responsável Pela Liberação',
        'rp_last_action' => 'Responsável pela ação',
        'picture_site' => 'Fotos site',
        'internal_picture' => 'Fotos internas',
        'advertisement' => 'Data anúncio',
        'status' => 'Status',
        'site' => 'Site',
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
