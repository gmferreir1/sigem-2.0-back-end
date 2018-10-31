<?php

namespace Modules\User\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\User\Entities\User;

/**
 * Class UserTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => (int) $model->id,
            'name' => $model->name,
            'last_name' => $model->last_name,
            'full_name' => "$model->name $model->last_name",
            'email' => $model->email,
            'type_profile' => $model->type_profile,
            'status' => $model->status,
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }
}
