<?php

namespace Modules\Register\Transformers\ReserveContract;

use League\Fractal\TransformerAbstract;
use Modules\Register\Entities\ReserveContract\ReserveContract;
use Modules\Sicadi\Entities\ImmobileType;

/**
 * Class ReserveContractTransformer.
 *
 * @package namespace App\Transformers;
 */
class ReserveContractTransformer extends TransformerAbstract
{
    /**
     * Transform the ReserveContract entity.
     *
     * @param ReserveContract $model
     *
     * @return array
     */
    public function transform(ReserveContract $model)
    {
        return [
            'id' => (int)$model->id,
            'attendant_register_id' => (int)$model->attendant_register_id,
            'attendant_register_name' => $this->getName($model->getAttendantRegisterData),
            'attendant_reception_id' => $model->attendant_reception_id,
            'attendant_reception_name' => $this->getName($model->getAttendantReceptionData),
            'immobile_code' => $model->immobile_code,
            'address' => $model->address,
            'neighborhood' => $model->neighborhood,
            'client_name' => $model->client_name,
            'client_rg' => $model->client_rg,
            'client_cpf' => $model->client_cpf,
            'client_profession' => $model->client_profession,
            'client_company' => $model->client_company,
            'client_address' => $model->client_address,
            'client_neighborhood' => $model->client_neighborhood,
            'client_city' => $model->client_city,
            'client_state' => $model->client_state,
            'client_phone_01' => $model->client_phone_01,
            'client_phone_02' => $model->client_phone_02,
            'client_phone_03' => $model->client_phone_03,
            'client_email' => $model->client_email,
            'type_location' => $model->type_location,
            'immobile_type' => $model->immobile_type,
            'immobile_type_name' => $this->getImmobileTypeName($model->immobile_type),
            'date_reserve' => $model->date_reserve,
            'prevision' => $model->prevision,
            'conclusion' => $model->conclusion,
            'situation' => $model->situation,
            'contract' => $model->contract,
            'date_init_contract' => $model->date_init_contract,
            'deadline' => $model->deadline,
            'taxa' => $model->taxa,
            'observation' => $model->observation,
            'origin_city' => $model->origin_city,
            'origin_state' => $model->origin_state,
            'finality' => $model->finality,
            'value' => $model->value,
            'value_negotiated' => (float) $model->value_negotiated,
            'duration_process' => $this->getDurationProcess($model),
            'code_reserve' => "$model->code_reserve/$model->year_reserve",
            'code_r' => $model->code_reserve,
            'year_r' => $model->year_reserve,
            'owner' => $model->owner,
            'owner_phone_01' => $model->owner_phone_01,
            'owner_phone_02' => $model->owner_phone_02,
            'owner_phone_03' => $model->owner_phone_03,
            'email_owner' => $model->email_owner,
            'email_tenant' => $model->email_tenant,
            'email_condominium' => $model->email_condominium,
            'id_reason_cancel' => $model->id_reason_cancel,
            'reason_cancel_name' => $this->getReasonCancel($model),
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at)),
        ];
    }

    private function getName($entityUser)
    {
        return "$entityUser->name $entityUser->last_name";
    }

    private function getDurationProcess($model)
    {
        $initDate = $model->date_reserve;
        $endDate = !$model->conclusion ? date('Y-m-d') : $model->conclusion;

        return daysDurationProcess($initDate, $endDate);
    }

    private function getImmobileTypeName($immobile_type_id)
    {
        if ($immobile_type_id) {
            $data = ImmobileType::where('type_immobile_id', $immobile_type_id)->first();
            if (isset($data->id)) {
                return getTypeImmobile($data->name_type_immobile);
            }
        }
        return '';
    }

    /**
     * Retorna o motivo do cancelamento
     * @param $model
     * @return string
     */
    private function getReasonCancel($model)
    {
        if ($model->id_reason_cancel) {

            $dataReasonCancel = $model->getReasonCancelData;

            return $dataReasonCancel->reason;
        }

        return null;
    }
}
