<?php

namespace Modules\Termination\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Termination\Entities\Historic;

/**
 * Class HistoricTransformer.
 *
 * @package namespace App\Transformers;
 */
class HistoricTransformer extends TransformerAbstract
{
    /**
     * Transform the Historic entity.
     *
     * @param Historic $model
     *
     * @return array
     */
    public function transform(Historic $model)
    {

        $rpLastActionEntity = $model->getRpLastActionData;

        return [
            'id' => (int)$model->id,
            'historic' => $model->historic,
            'contract_id' => (int)$model->contract_id,
            'rp_last_action_name' => "$rpLastActionEntity->name $rpLastActionEntity->last_name",
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }
}
