<?php

namespace Modules\ImmobileCaptured\Transformers\ReportList;

use League\Fractal\TransformerAbstract;
use Modules\ImmobileCaptured\Entities\ReportList\ReportList;

/**
 * Class ReportListTransformer.
 *
 * @package namespace App\Transformers;
 */
class ReportListTransformer extends TransformerAbstract
{
    /**
     * Transform the ReportList entity.
     *
     * @param ReportList $model
     *
     * @return array
     */
    public function transform(ReportList $model)
    {
        return [
            'id' => (int)$model->id,
            'immobile_code' => $model->immobile_code,
            'address' => $model->address,
            'neighborhood' => $model->neighborhood,
            'value' => (float)$model->value,
            'owner' => $model->owner,
            'type_immobile' => $model->type_immobile,
            'type_immobile_name' => $this->getTypeImmobileName($model),
            'type_location' => $model->type_location,
            'captured_date' => $model->captured_date,
            'responsible' => $model->responsible,
            'responsible_name' => $this->getResponsibleName($model),
            'rp_last_action' => $model->rp_last_action,
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }

    /**
     * @param $model
     * @return string
     */
    private function getResponsibleName($model) : string
    {
        $entityUser = $model->getResponsibleData;

        return "$entityUser->name $entityUser->last_name";
    }

    /**
     * @param $model
     * @return string
     */
    private function getTypeImmobileName($model)
    {
        $entityTypeImmobile = $model->getTypeImmobile;

        if ($entityTypeImmobile) {
            return $entityTypeImmobile->name_type_immobile;
        }

        return null;
    }
}
