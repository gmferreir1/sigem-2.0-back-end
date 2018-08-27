<?php

namespace Modules\Register\Transformers\ReserveHistoric;

use League\Fractal\TransformerAbstract;
use Modules\Register\Entities\ReserveHistoric\ReserveHistoric;

/**
 * Class HistoricTransformer.
 *
 * @package namespace App\Transformers;
 */
class ReserveHistoricTransformer extends TransformerAbstract
{
    /**
     * Transform the Historic entity.
     *
     * @param ReserveHistoric $model
     *
     * @return array
     */
    public function transform(ReserveHistoric $model)
    {
        return [
            'id' => (int) $model->id,
            'historic' => $model->historic,
            'reserve_id' => $model->reserve_id,
            'rp_last_action' => $model->rp_last_action,
            'rp_last_action_name' => $this->getRpActionName($model),
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }

    /**
     * @param $model
     * @return string
     */
    private function getRpActionName($model) :string
    {
        $responsibleData = $model->getRpLastActionData;
        return "$responsibleData->name $responsibleData->last_name";
    }
}
