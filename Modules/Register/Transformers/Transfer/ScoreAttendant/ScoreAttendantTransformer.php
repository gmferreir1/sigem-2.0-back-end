<?php

namespace Modules\Register\Transformers\Transfer\ScoreAttendant;

use League\Fractal\TransformerAbstract;
use Modules\Register\Entities\Transfer\ScoreAttendant\ScoreAttendant;

/**
 * Class ScoreAttendantTransformer.
 *
 * @package namespace App\Transformers;
 */
class ScoreAttendantTransformer extends TransformerAbstract
{
    /**
     * Transform the ScoreAttendant entity.
     *
     * @param ScoreAttendant $model
     *
     * @return array
     */
    public function transform(ScoreAttendant $model)
    {
        return [
            'id' => (int)$model->id,
            'attendant_id' => (int)$model->attendant_id,
            'rp_last_action' => (int)$model->rp_last_action,
            'score' => (int)$model->score,
            'attendance_name' => $this->getAttendanceName($model),
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at)),
        ];
    }

    /**
     * @param $model
     * @return string
     */
    private function getAttendanceName($model) : string
    {
        $userData = $model->getAttendanceData;

        return "$userData->name $userData->last_name";
    }
}
