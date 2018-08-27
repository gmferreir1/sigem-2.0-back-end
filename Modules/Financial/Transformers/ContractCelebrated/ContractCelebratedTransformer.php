<?php

namespace Modules\Financial\Transformers\ContractCelebrated;

use League\Fractal\TransformerAbstract;
use Modules\Financial\Entities\ContractCelebrated\ContractCelebrated;

/**
 * Class ContractCelebratedTransformer.
 *
 * @package namespace App\Transformers;
 */
class ContractCelebratedTransformer extends TransformerAbstract
{
    /**
     * Transform the ContractCelebrated entity.
     *
     * @param ContractCelebrated $model
     *
     * @return array
     */
    public function transform(ContractCelebrated $model)
    {
        return [
            'id' => (int)$model->id,
            'reserve_id' => (int)'reserve_id',
            'contract' => $model->contract,
            'immobile_code' => $model->immobile_code,
            'address' => $model->address,
            'neighborhood' => $model->neighborhood,
            'owner_name' => $model->owner_name,
            'conclusion' => $model->conclusion,
            'type_contract' => $model->type_contract,
            'ticket' => $model->ticket,
            'tx_contract' => $model->tx_contract,
            'bank_expense' => $model->bank_expense,
            'subscription_iptu' => $model->subscription_iptu,
            'period_contract' => $model->period_contract,
            'delivery_key' => $model->delivery_key,
            'rp_last_action' => $model->rp_last_action,
            'status' => $model->status,
            'status_iptu' => $model->status_iptu,
            'status_tcrs' => $model->status_tcrs,
            'due_date_rent' => $model->due_date_rent,
            'loyalty_discount' => $model->loyalty_discount,
            'sync' => $model->sync,
            'rp_release_name' => $this->getRpReleaseName($model),
            'created_at' => date('Y-m-d h:m:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d h:m:s', strtotime($model->updated_at))
        ];
    }

    /**
     * @param $model
     * @return string
     */
    private function getRpReleaseName($model) : string
    {
        $rpReleaseEntity = $model->getRpReleaseData;

        return "$rpReleaseEntity->name $rpReleaseEntity->last_name";
    }
}
