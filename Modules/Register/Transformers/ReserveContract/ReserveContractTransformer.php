<?php

namespace Modules\Register\Transformers\ReserveContract;

use League\Fractal\TransformerAbstract;
use Modules\Register\Entities\ReserveContract\ReserveContract;

/**
 * Class ReserveContractTransformer.
 *
 * @package namespace App\Transformers;
 */
class ReserveContractTransformer extends TransformerAbstract
{
    /**
     * Transform the ReserveContract entity.
     *
     * @param ReserveContract $model
     *
     * @return array
     */
    public function transform(ReserveContract $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
