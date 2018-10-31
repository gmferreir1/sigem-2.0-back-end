<?php

namespace Modules\Register\Transformers\Transfer\Historic;

use League\Fractal\TransformerAbstract;
use Modules\Register\Entities\Transfer\Historic\Historic;

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
        return [
            'id' => (int)$model->id,
            'historic' => $model->historic,
            'rp_last_action_name' => $this->getRpLastActionName($model),
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }

    /**
     * @param $model
     * @return string
     */
    private function getRpLastActionName($model) : string
    {
        $rpLastActionData = $model->rpLastActionData;
        return "$rpLastActionData->name $rpLastActionData->last_name";
    }
}
