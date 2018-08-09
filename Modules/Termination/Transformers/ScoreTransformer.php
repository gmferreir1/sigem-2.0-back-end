<?php

namespace Modules\Termination\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Termination\Entities\Score;

/**
 * Class ScoreTransformer.
 *
 * @package namespace App\Transformers;
 */
class ScoreTransformer extends TransformerAbstract
{
    /**
     * Transform the Score entity.
     *
     * @param Score $model
     *
     * @return array
     */
    public function transform(Score $model)
    {
        $attendantData = $model->getAttendantData;

        return [
            'id' => (int)$model->id,
            'attendant_id' => (int)$model->attendant_id,
            'score' => (int)$model->score,
            'name' => "$attendantData->name $attendantData->last_name",
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }
}
