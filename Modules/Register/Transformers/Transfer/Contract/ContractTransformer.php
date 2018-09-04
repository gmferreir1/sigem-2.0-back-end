<?php

namespace Modules\Register\Transformers\Transfer\Contract;

use League\Fractal\TransformerAbstract;
use Modules\Register\Entities\Transfer\Contract\Contract;

/**
 * Class ContractTransformer.
 *
 * @package namespace App\Transformers;
 */
class ContractTransformer extends TransformerAbstract
{
    /**
     * Transform the Contract entity.
     *
     * @param Contract $model
     *
     * @return array
     */
    public function transform(Contract $model)
    {

        return [
            'id'         => (int) $model->id,
            'contract' => $model->contract,
            'immobile_code' => $model->immobile_code,
            'address' => $model->address,
            'neighborhood' => $model->neighborhood,
            'value' => $model->value,
            'owner' => $model->owner,
            'owner_phone_residential' => $model->owner_phone_residential,
            'owner_phone_commercial' => $model->owner_phone_commercial,
            'owner_cell_phone' => $model->owner_cell_phone,
            'owner_email' => $model->owner_email,
            'requester_name' => $model->requester_name,
            'requester_phone_01' => $model->requester_phone_01,
            'requester_phone_02' => $model->requester_phone_02,
            'requester_phone_03' => $model->requester_phone_03,
            'requester_email' => $model->requester_email,
            'transfer_date' => $model->transfer_date,
            'status' => $model->status,
            'new_contract' => $model->new_contract,
            'end_process' => $model->end_process,
            'days_duration_process' => $this->calculateTimeEndProcess($model),
            'reason_id' => (int) $model->reason_id,
            'reason_name' => $this->getReasonName($model),
            'responsible_transfer_id' => $model->responsible_transfer_id,
            'responsible_transfer_name' => $this->getResponsibleTransferName($model),
            'created_at' => date('Y-m-d', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d', strtotime($model->updated_at)),
        ];
    }

    /**
     * Calcula o tempo de duração do processo de transferência
     * @param $model
     * @return string
     */
    private function calculateTimeEndProcess($model)
    {
        $current_date = date('Y-m-d');
        if($model->status == 'p') {
            $time_process = daysDurationProcess($model->transfer_date, $current_date);
        } else {
            if($model->end_process && $model->status  == 'r' || $model->status == 'c') {
                $time_process = daysDurationProcess($model->transfer_date, $model->end_process);
            }
            else {
                $time_process = 0;
            }
        }
        return $time_process;
    }

    /**
     * @param $model
     * @return mixed
     */
    private function getReasonName($model)
    {
        return $model->getReasonData->reason;
    }

    /**
     * @param $model
     * @return string
     */
    private function getResponsibleTransferName($model) : string
    {
        $responsibleTransferData = $model->getResponsibleTransferData;
        return "$responsibleTransferData->name $responsibleTransferData->last_name";
    }
}
