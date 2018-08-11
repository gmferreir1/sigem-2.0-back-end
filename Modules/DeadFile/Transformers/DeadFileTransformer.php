<?php

namespace Modules\DeadFile\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\DeadFile\Entities\DeadFile;

/**
 * Class DeadFileTransformer.
 *
 * @package namespace App\Transformers;
 */
class DeadFileTransformer extends TransformerAbstract
{
    /**
     * Transform the DeadFile entity.
     *
     * @param DeadFile $model
     *
     * @return array
     */
    public function transform(DeadFile $model)
    {
        return [
            'id' => (int)$model->id,
            'termination_id' => $model->termination_id,
            'contract' => $model->contract,
            'termination_date' => $model->termination_date,
            'cashier' => $model->cashier,
            'file' => $model->file,
            'type_release' => $model->type_release,
            'status' => $model->status,
            'year_release' => $model->year_release,
            'rp_last_action_name' => $this->getRpLastActionName($model),
            'created_at' => !$model->created_at ? null : date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => !$model->updated_at ? null : date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }

    /**
     * @param $model
     * @return string
     */
    private function getRpLastActionName($model) : string
    {
        $rpLastAction = $model->getRpLastActionData;

        return "$rpLastAction->name $rpLastAction->last_name";
    }
}
