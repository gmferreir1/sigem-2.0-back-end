<?php

namespace Modules\Register\Transformers\Transfer\Contract;

use League\Fractal\TransformerAbstract;
use Modules\Register\Entities\Contract\Contract;

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

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
