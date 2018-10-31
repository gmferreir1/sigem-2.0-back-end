<?php

namespace Modules\Termination\Services;

use Modules\User\Services\UserServiceCrud;

class ContractReportService
{
    /**
     * @var UserServiceCrud
     */
    protected $userServiceCrud;
    /**
     * @var DestinationOrReasonServiceCrud
     */
    private $destinationOrReasonServiceCrud;

    public function __construct(UserServiceCrud $userServiceCrud, DestinationOrReasonServiceCrud $destinationOrReasonServiceCrud)
    {
        $this->userServiceCrud = $userServiceCrud;
        $this->destinationOrReasonServiceCrud = $destinationOrReasonServiceCrud;
    }

    /**
     * Gera relatório quantitativo dos dados passados por parametro
     * @param array $data
     * @return array
     */
    public function getReportData(array $data): array
    {
        $collection = collect($data);

        /*
         * Total
         */
        $total = [
            'qt' => $collection->count(),
            'value' => $collection->sum('value')
        ];

        /*
         * Residencial
         */
        $residential = $collection->where('type_location', 're');
        $residential_report = [
            'qt' => $residential->count(),
            'value' => $residential->sum('value'),
            'percent' => $total['qt'] == 0 ? 0 : round(($residential->count() * 100) / $total['qt'], 2)
        ];

        /*
         * Comercial
         */
        $commercial = $collection->where('type_location', 'co');
        $commercial_report = [
            'qt' => $commercial->count(),
            'value' => $commercial->sum('value'),
            'percent' => $total['qt'] == 0 ? 0 : round(($commercial->count() * 100) / $total['qt'], 2)
        ];

        /*
         * Faço o calculo da media de dias
         */
        $median_days = $total['qt'] > 0 ? medianDays($collection->sum('time_duration_contract_in_days') / $total['qt'] ) : 0;

        return [
            'total' => $total,
            'residential' => $residential_report,
            'commercial' => $commercial_report,
            'median_contracts' =>  $median_days,
        ];
    }

    /**
     * Retorna os nomes dos responsáveis na para exibir no cabeçalho de impressão de relatório
     * @param array $responsible
     * @return string
     */
    public function getResponsibleForPrint(array $responsible)
    {
        if (count($responsible) > 1) {
            return "todos responsaveis";
        }

        $user = $this->userServiceCrud->find($responsible[0]);

        return $user->name . ' ' . $user->last_name;
    }

    /**
     * Retorna os destinos
     * @param $data
     * @return array
     */
    public function getDestinations(array $data): array
    {
        $rent_again = collect($data)->where('rent_again', 'y');
        $destination_unique = $rent_again->unique('destination_id');
        $results = [];

        foreach ($destination_unique->all() as $key => $item) {
            if($item['destination_id']) {
                $destination = $rent_again->where('destination_id', $item['destination_id']);

                $results[$key] = [
                    'destination' => $this->destinationOrReasonServiceCrud->find($item['destination_id'])->text,
                    'qt' => $destination->count(),
                    'value' => $destination->sum('value'),
                    'percent' => $rent_again->count() == 0 ? 0 : round(($destination->count() * 100) / $rent_again->count(), 2)
                ];
            }
        }

        sort($results);
        $sort_rent_again = collect($results);
        $sorted_rent_again = $sort_rent_again->sortByDesc('qt')->values()->all();

        return [
            'total_rent_again' => $rent_again->count(),
            'report_rent_again' => $sorted_rent_again
        ];
    }

    /**
     * Retorna os motivos
     * @param $data
     * @return array
     */
    public function getReasons(array $data): array
    {
        $collection = collect($data);
        $reason_unique = $collection->unique('reason_id');
        $results = [];
        foreach ($reason_unique as $key => $item) {
            $reason = $collection->where('reason_id', $item['reason_id']);
            $results[$key] = [
                'reason' => $this->destinationOrReasonServiceCrud->find($item['reason_id'])->text,
                'qt' => $reason->count(),
                'value' => $reason->sum('value'),
                'percent' => $collection->count() == 0 ? 0 : round(($reason->count() * 100) / $collection->count(), 2)
            ];
        }

        sort($results);
        $sort_reason = collect($results);
        $sorted_reason = $sort_reason->sortByDesc('qt')->values()->all();

        return [
            'total_reason' => $collection->count(),
            'report_reason' => $sorted_reason
        ];
    }

    /**
     * Retorna os dados dos vistoriador
     * @param $data
     * @return array
     */
    public function getSurvey(array $data): array
    {
        $collection = collect($data)->whereNotIn('surveyor_id', "");
        $caveat = $collection->where('caveat', true);
        $surveyor_unique = $collection->unique('surveyor_id');
        $results = [];

        foreach ($surveyor_unique->all() as $key => $item) {

            $surveyor_name = null;
            $survey =  $collection->where('surveyor_id', $item['surveyor_id']);

            if($item['surveyor_id']) {
                $user = $this->userServiceCrud->find($item['surveyor_id']);
                $surveyor_name = $user->name . ' ' . $user->last_name;
            }

            $results[$key] = [
                'surveyor_name' => $surveyor_name,
                'qt' => $collection->where('surveyor_id', $item['surveyor_id'])->count(),
                'qt_caveat' => $caveat->where('surveyor_id', $item['surveyor_id'])->count(),
                'percent' => $collection->count() == 0 ? 0 : round(($survey->count() * 100) / $collection->count(), 2)
            ];
        }

        $sort_surveyor = collect($results);
        $sorted_surveyor = $sort_surveyor->sortByDesc('qt')->values()->all();

        return [
            'total_survey' => $collection->count(),
            'report_survey' => $sorted_surveyor
        ];
    }

}