<?php

namespace Modules\Termination\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Termination\Entities\ImmobileRelease;

/**
 * Class ImmobileReleaseForFilterTransformer.
 *
 * @package namespace App\Transformers;
 */
class ImmobileReleaseForFilterTransformer extends TransformerAbstract
{
    /**
     * Transform the ImmobileReleaseForFilter entity.
     *
     * @param ImmobileRelease $model
     *
     * @return array
     */
    public function transform(ImmobileRelease $model)
    {
        return [
            'rp_receive' => $model->rp_receive,
            'rp_receive_name' => $this->getReceiveDataName($model)
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
