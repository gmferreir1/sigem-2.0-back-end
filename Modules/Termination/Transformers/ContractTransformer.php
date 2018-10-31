<?php

namespace Modules\Termination\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Termination\Entities\Contract;

/**
 * Class ContractTransformer.
 *
 * @package namespace App\Transformers;
 */
class ContractTransformer extends TransformerAbstract
{
    /**
     * Transform the Contract entity.
     *
     * @param Contract $model
     *
     * @return array
     */
    public function transform(Contract $model)
    {
        return [
            'id'         => (int) $model->id,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
