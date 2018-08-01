<?php

namespace Modules\ManagerAction\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\ManagerAction\Entities\ActionDatabase;

/**
 * Class ActionDatabaseTransformer.
 *
 * @package namespace App\Transformers;
 */
class ActionDatabaseTransformer extends TransformerAbstract
{
    /**
     * Transform the ActionDatabase entity.
     *
     * @param ActionDatabase $model
     *
     * @return array
     */
    public function transform(ActionDatabase $model)
    {
        $rpActionEntity = $model->getRpActionData;

        return [
            'id' => (int)$model->id,
            'table_name' => $model->table_name,
            'status' => $model->status,
            'rp_action_name' => "$rpActionEntity->name $rpActionEntity->last_name",
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }
}
