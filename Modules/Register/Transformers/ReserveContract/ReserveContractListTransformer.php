<?php

namespace Modules\Register\Transformers\ReserveContract;

use League\Fractal\TransformerAbstract;
use Modules\Register\Entities\ReserveContract\ReserveContract;

/**
 * Class ReserveContractListTransformer.
 *
 * @package namespace App\Transformers;
 */
class ReserveContractListTransformer extends TransformerAbstract
{
    /**
     * Transform the ReserveContractList entity.
     *
     * @param ReserveContract $model
     *
     * @return array
     */
    public function transform(ReserveContract $model)
    {
        return [
            'id' => (int)$model->id,
            'attendant_register_name' => $this->getName($model->getAttendantRegisterData),
            'attendant_reception_name' => $this->getName($model->getAttendantReceptionData),
            'immobile_code' => $model->immobile_code,
            'date_reserve' => $model->date_reserve,
            'client_name' => $model->client_name,
            'prevision' => $model->prevision,
            'conclusion' => $model->conclusion,
            'situation' => $model->situation,
            'contract' => $model->contract,
            'date_init_contract' => $model->date_init_contract,
            'value' => $model->value,
            'value_negotiated' => (float) $model->value_negotiated,
            'duration_process' => $this->getDurationProcess($model),
            'code_reserve' => "$model->code_reserve/$model->year_reserve",
            'code_r' => $model->code_reserve,
            'year_r' => $model->year_reserve,
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

}
