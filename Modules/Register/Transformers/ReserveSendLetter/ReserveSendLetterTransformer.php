<?php

namespace Modules\Register\Transformers\ReserveSendLetter;

use League\Fractal\TransformerAbstract;
use Modules\Register\Entities\ReserveSendLetter\ReserveSendLetter;

/**
 * Class ReserveSendLetterTransformer.
 *
 * @package namespace App\Transformers;
 */
class ReserveSendLetterTransformer extends TransformerAbstract
{
    /**
     * Transform the ReserveSendLetter entity.
     *
     * @param ReserveSendLetter $model
     *
     * @return array
     */
    public function transform(ReserveSendLetter $model)
    {
        return [
            'id' => (int)$model->id,
            'letter_name' => $model->letter_name,
            'reserve_id' => $model->reserve_id,
            'rp_last_action' => $model->rp_last_action,
            'rp_last_action_name' => $this->getRpLastActionName($model),

            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }

    private function getRpLastActionName($model) : string
    {
        $rpLastActionEntity = $model->getRpLastActionData;

        return "$rpLastActionEntity->name $rpLastActionEntity->last_name";
    }
}
