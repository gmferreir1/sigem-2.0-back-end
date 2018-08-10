<?php

namespace Modules\Termination\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Modules\Termination\Entities\Contract;

/**
 * Class ContractListPrinterTransformer.
 *
 * @package namespace App\Transformers;
 */
class ContractListPrinterTransformer extends TransformerAbstract
{
    /**
     * Transform the ContractListPrinter entity.
     *
     * @param Contract $model
     *
     * @return array
     */
    public function transform(Contract $model)
    {
        $date_primary_contract = $this->getContractData($model->contract);

        return [
            'contract' => $model->contract,
            'immobile_code' => $model->immobile_code,
            'address' => $model->address,
            'neighborhood' => $model->neighborhosod,
            'immobile_type' => $model->immobile_type,
            'type_location' => $model->type_location,
            'tenant' => $model->tenant,
            'tenant' => $model->tenant,
            'owner' => $model->owner,
            'type_register' => $model->type_register,
            'termination_date' => $model->termination_date,
            'value' => $model->value,
            'status' => $model->status,
            'rp_per_inactivate_name' => $this->getResponsiblePerInactivatedName($model),
            'reason_id' => $model->reason_id,
            'reason' => $this->getReasonName($model),
            'destination_id' => $model->destination_id,
            'rent_again' => $model->rent_again,
            'surveyor_id' => $model->surveyor_id,
            'caveat' => $model->caveat,
            'destination' => $this->getDestinationName($model),
            'end_process' => $model->end_process,
            'duration_process' => $this->getTimeEndProcess($model),
            'date_primary_contract' => $date_primary_contract,
            'time_duration_contract' => $this->timeDurationContract($date_primary_contract, $model->termination_date),
            'time_duration_contract_in_days' => $this->diffDateInDay($date_primary_contract, $model->termination_date),
            'created_at' => date('Y-m-d H:i:s', strtotime($model->created_at)),
            'updated_at' => date('Y-m-d H:i:s', strtotime($model->updated_at)),
        ];
    }


    private function getResponsiblePerInactivatedName($model): string
    {
        $rpPerInactivated = $model->getResponsiblePerInactivated;

        return "$rpPerInactivated->name $rpPerInactivated->last_name";
    }

    private function getReasonName($model): string
    {
        if ($model->reason_id) {
            return $model->getReasonData->text;
        }

        return '';
    }

    private function getDestinationName($model): string
    {
        if ($model->destination_id) {
            return $model->getDestinationData->text;
        }

        return '';
    }

    private function getTimeEndProcess($model)
    {
        $current_date = date('Y-m-d');

        if ($model->end_process) {

            $time_process = daysDurationProcess($model->end_process, $model->termination_date);

        } else {

            if ($model->termination_date) {
                $time_process = daysDurationProcess($model->termination_date, $current_date);
            } else {
                $time_process = 0;
            }

        }

        return $time_process;
    }

    private function getContractData($contract): string
    {
        $data = \Modules\Sicadi\Entities\Contract::where('contract_code', $contract)->get(['date_primary_contract']);

        if (count($data) > 0) {
            return Carbon::createFromFormat('d/m/Y', $data[0]['date_primary_contract'])->format('Y-m-d');
        }

        return '';
    }

    private function timeDurationContract($init_date, $end_date)
    {
        if ($init_date and $end_date) {

            $data1 = new \DateTime($init_date);
            $data2 = new \DateTime($end_date);

            $intervalo = $data1->diff($data2);

            return [
                'y' => $intervalo->y,
                'm' => $intervalo->m,
                'd' => $intervalo->d,
            ];
        }

        return null;
    }

    private function diffDateInDay($init_date, $end_date)
    {

        if ($init_date and $end_date) {

            $diff = strtotime($end_date) - strtotime($init_date);

            return floor($diff / (60 * 60 * 24));
        }

        return 0;
    }
}
