<?php

namespace Modules\Register\Transformers\ScoreAttendance;

use League\Fractal\TransformerAbstract;
use Modules\Register\Entities\ScoreAttendance\ScoreAttendance;

/**
 * Class ScoreAttendanceTransformer.
 *
 * @package namespace App\Transformers;
 */
class ScoreAttendanceTransformer extends TransformerAbstract
{
    /**
     * Transform the ScoreAttendance entity.
     *
     * @param ScoreAttendance $model
     *
     * @return array
     */
    public function transform(ScoreAttendance $model)
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
