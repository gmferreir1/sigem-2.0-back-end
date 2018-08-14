<?php

namespace Modules\Termination\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Termination\Entities\Contract;

/**
 * Class ContractListTransformer.
 *
 * @package namespace App\Transformers;
 */
class ContractListTransformer extends TransformerAbstract
{
    /**
     * Transform the ContractList entity.
     *
     * @param Contract $model
     *
     * @return array
     */
    public function transform(Contract $model)
    {
        return [
            'id' => (int)$model->id,
            'rp_per_inactive' => $model->rp_per_inactive,
            'rp_per_inactive_name' => $this->getRpPerInactiveName($model),
            'contract' => $model->contract,
            'immobile_type' => $model->immobile_type,
            'tenant' => $model->tenant,
            'type_register' => $model->type_register,
            'termination_date' => $model->termination_date,
            'value' => (float) $model->value,
            'reason_name' => $this->getReason($model),
            'status' => $this->getStatus($model->status),
            'end_process' => $model->end_process,
            'duration_process' => $this->getTimeEndProcess($model),
            'destination_name' => $this->getDestination($model),
            'archive' => $model->archive,
            'release_immobile' => $model->release_immobile,
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at))
        ];
    }

    /**
     * Retorna o nome do responsável pela inativação
     * @param $model
     * @return string
     */
    private function getRpPerInactiveName($model): string
    {
        $rpPerInactiveEntity = $model->getResponsiblePerInactivated;

        return "$rpPerInactiveEntity->name $rpPerInactiveEntity->last_name";
    }

    /**
     * Retorna o motivo da inativação
     * @param $model
     * @return string
     */
    private function getReason($model)
    {
        if ($model->getReasonData) {
            return $model->getReasonData->text;
        }

        return null;
    }

    /**
     * Retorna o destino da inativação
     * @param $model
     * @return null
     */
    private function getDestination($model)
    {
        if ($model->getDestinationData) {
            return $model->getDestinationData->text;
        }

        return null;
    }

    /**
     * Retorna o tempo de duração do processo
     * @param $model
     * @return int
     */
    private function getTimeEndProcess($model)
    {
        $current_date = date('Y-m-d');

        if($model->end_process) {
            $time_process = daysDurationProcess($model->end_process, $model->termination_date);
        } else {

            if($model->termination_date) {
                $time_process = daysDurationProcess($model->termination_date, $current_date);
            } else {
                $time_process = 0;
            }

        }

        return $time_process;
    }

    /**
     * Retorna o status
     * @param string $status
     * @return string
     */
    private function getStatus(string $status) : string
    {
        if ($status == 'p') {
            return 'pendente';
        }

        if ($status == 'r') {
            return 'resolvido';
        }

        if ($status == 'a') {
            return 'acordo';
        }

        if ($status == 'j') {
            return 'justiça';
        }

        if ($status == 'cej') {
            return 'cob.ext.jud';
        }

        if ($status == 'c') {
            return 'cancelado';
        }
    }
}
