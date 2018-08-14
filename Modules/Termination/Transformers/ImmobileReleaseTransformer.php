<?php

namespace Modules\Termination\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Termination\Entities\ImmobileRelease;

/**
 * Class ImmobileReleaseTransformer.
 *
 * @package namespace App\Transformers;
 */
class ImmobileReleaseTransformer extends TransformerAbstract
{
    /**
     * Transform the ImmobileRelease entity.
     *
     * @param ImmobileRelease $model
     *
     * @return array
     */
    public function transform(ImmobileRelease $model)
    {
        return [
            'id' => (int)$model->id,
            'immobile_code' => $model->immobile_code,
            'inactivate_date' => $model->inactivate_date,
            'rp_receive' => $model->rp_receive,
            'rp_receive_name' => $this->getReceiveDataName($model),
            'date_send' => $model->date_send,
            'duration_inactivate_to_release' => daysDurationProcess($model->inactivate_date, $model->date_send),
            'site' => $model->site,
            'picture_site' => $model->picture_site,
            'internal_picture' => $model->internal_picture,
            'observation' => $model->observation,
            'advertisement' => $model->advertisement,
            'status' => $model->status,
            'duration_immobile_release_process' => !$model->advertisement ? null : daysDurationProcess($model->date_send, $model->advertisement),
            'duration_total_process' => (int)daysDurationProcess($model->inactivate_date, $model->date_send) + ((int)!$model->advertisement ? 0 : (int)daysDurationProcess($model->date_send, $model->advertisement)),
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }

    /**
     * @param $model
     * @return string
     */
    protected function getReceiveDataName($model) : string
    {
        $rpReceiveData = $model->getRpReceiveData;

        return "$rpReceiveData->name $rpReceiveData->last_name";
    }
}
