<?php

namespace Modules\Register\Transformers\Transfer\Reason;

use League\Fractal\TransformerAbstract;
use Modules\Register\Entities\Transfer\Reason\Reason;

/**
 * Class ReasonTransformer.
 *
 * @package namespace App\Transformers;
 */
class ReasonTransformer extends TransformerAbstract
{
    /**
     * Transform the Reason entity.
     *
     * @param Reason $model
     *
     * @return array
     */
    public function transform(Reason $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
