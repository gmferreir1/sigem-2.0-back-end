<?php

namespace Modules\SystemGoal\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\SystemGoal\Entities\SystemGoal;

/**
 * Class SystemGoalTransformer.
 *
 * @package namespace App\Transformers;
 */
class SystemGoalTransformer extends TransformerAbstract
{
    /**
     * Transform the SystemGoal entity.
     *
     * @param SystemGoal $model
     *
     * @return array
     */
    public function transform(SystemGoal $model)
    {
        return [
            'id'         => (int) $model->id,
            'name' => $model->name,
            'type' => $model->type,
            'value' => (float) $model->value,
            'percent' => (int) $model->percent,
            'sob_goal' => $model->sob_goal,
            'rp_last_action_name' => $this->getRpLastActionName($model),
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }

    private function getRpLastActionName($model) : string
    {
        $userEntity = $model->getRpLastActionData;

        return "$userEntity->name $userEntity->last_name";
    }
}
