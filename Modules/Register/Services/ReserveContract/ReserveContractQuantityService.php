<?php

namespace Modules\RegisterReserve\Services;


use App\Traits\Generic\DateTime;
use Modules\Register\Services\ReserveContract\ReserveContractServiceCrud;
use Modules\Register\Services\ReserveReasonCancel\ReserveReasonCancelServiceCrud;
use Modules\User\Services\UserServiceCrud;

class ReserveContractQuantityService
{
    use DateTime;

    protected $yearReport;
    protected $monthReport;
    /**
     * @var ReserveContractServiceCrud
     */
    private $contractServiceCrud;
    /**
     * @var UserServiceCrud
     */
    private $userServiceCrud;
    /**
     * @var ReserveReasonCancelServiceCrud
     */
    private $reasonCancelServiceCrud;

    public function __construct(ReserveContractServiceCrud $contractServiceCrud, UserServiceCrud $userServiceCrud, ReserveReasonCancelServiceCrud $reasonCancelServiceCrud)
    {
        $this->contractServiceCrud = $contractServiceCrud;
        $this->userServiceCrud = $userServiceCrud;
        $this->reasonCancelServiceCrud = $reasonCancelServiceCrud;
    }

    /**
     * Monta relatório quantitativo de acordo com o os dados passados por parâmetro
     * @param array $data
     * @param array $filter
     * @return array
     */
    public function generateReportQt(array $data, array $filter = [])
    {

        /*
         * Assinados do mês, caso o usuário não selecione o filtro
         */
        if (!in_array('as', $filter['status'])) {

            $closure = function ($query) {
                return $query->where('situation', 'as')
                            ->whereBetween('conclusion', [$this->initDateCurrentMonth(date('Y'), date('m')), $this->endDateCurrentMonth(date('Y'), date('m'))]);
            };

            $assignMonth = $this->contractServiceCrud->scopeQuery($closure)->toArray();
        } else {
            $assignMonth = $data;
        }

        /*
         * Cancelados do mês, caso o usuário não selecione o filtro
         */

        if (!in_array('c', $filter['status'])) {

            $closure = function ($query) {
                return $query->where('situation', 'c')
                    ->whereBetween('conclusion', [$this->initDateCurrentMonth(date('Y'), date('m')), $this->endDateCurrentMonth(date('Y'), date('m'))]);
            };

            $cancelMonth = $this->contractServiceCrud->scopeQuery($closure)->toArray();
        } else {
            $cancelMonth = $data;
        }

        return [
            'total' => $this->reportData($data),
            'reserve' => $this->reportData($data, 'r'),
            'documentation' => $this->reportData($data, 'd'),
            'analyze' => $this->reportData($data, 'a'),
            'register' => $this->reportData($data, 'cd'),
            'pending' => $this->reportData($data, 'p'),
            'assigned' => $this->reportData($assignMonth, 'as'),
            'assigned_pending' => $this->reportData($data, 'ap'),
            'active_final' => $this->reportData($data, 'af'),
            'cancel' => $this->reportData($cancelMonth, 'c'),
        ];
    }

    public function generateReportQtContractCelebrated(array $data): array
    {
        return [
            'residential' => $this->reportDataContractCelebrated($data, 'r'),
            'commercial' => $this->reportDataContractCelebrated($data, 'c'),
            'total' => $this->reportDataContractCelebrated($data),
            'total_taxa' => $this->totalTaxaAdmin($data),
            'per_user' => $this->totalContractPerUser($data)
        ];
    }

    /**
     * @param array $data
     * @return float|string
     */
    public function timeMedian(array $data)
    {
        $days = 0;
        foreach ($data as $item) {
            $days = daysDurationProcess($item['date_reserve'], $item['conclusion']) + $days;
        }

        $medianDays = round($days / count($data));


        return $median = medianDays($medianDays);
    }

    private function reportData(array $data, string $situation = null): array
    {
        if ($situation) {
            $collection = collect($data)->where('situation', $situation);
        } else {
            $collection = collect($data);
        }

        return [
            'qt' => $collection->count(),
            'value' => $collection->sum('value_negotiated')
        ];
    }

    private function reportDataContractCelebrated(array $data, string $typeLocation = null)
    {
        if ($typeLocation) {
            $collection = collect($data)->where('type_location', $typeLocation);
        } else {
            $collection = collect($data);
        }

        $percent = !$collection->count() ? 0 : round(($collection->count() / collect($data)->count()) * 100, 2);

        return [
            'qt' => $collection->count(),
            'value' => $collection->sum('value_negotiated'),
            'percent' => $percent
        ];
    }

    private function totalContractPerUser($data)
    {
        $report = [];
        $collection = collect($data);
        $uniqueAttendance = $collection->unique('attendant_register_id')->toArray();

        foreach ($uniqueAttendance as $key => $item) {
            $userData = $this->userServiceCrud->find($item['attendant_register_id']);
            $collectionUser = $collection->where('attendant_register_id', $item['attendant_register_id']);

            $percent = (float) $collection->sum('value_negotiated') == 0 ? 0 : round(((float) $collectionUser->sum('value_negotiated') * 100) / (float) $collection->sum('value_negotiated'), 2);

            $report[$key] = $this->reportDataContractCelebrated($collectionUser->toArray());
            $report[$key]['name'] = "$userData->name $userData->last_name";
            $report[$key]['percent'] = $percent;
        }

        return $this->sort($report, 'name');
    }

    /**
     * Calculo taxa administrativa
     * @param array $data
     * @return float
     */
    private function totalTaxaAdmin(array $data) : float
    {

        $valueTaxa = 0;
        foreach ($data as $key => $item) {
            $valueTaxa = calcTxAdm($item['value_negotiated'], $item['taxa']) + $valueTaxa;
        }

        return (float) $valueTaxa;
    }



    public function getReportMonitoringReserve($month, $year)
    {

        $this->yearReport = $year;
        $this->monthReport= $month;

        $nextMonth  = $month == 12 ? 1 : $month + 1;

        $reservesPreviousMonth = $this->reservePreviousMonth();
        $reservesMonth = $this->reservesMonth();
        $reservesMonthCanceled = $this->reservesMonthCanceled();
        $reservesMonthSigned = $this->reserveSigned();
        $reservesNextMonth = $this->reserveNextMonth();

        return [
            'previous_month' => [
                'total' => $this->reportTotalReserves($reservesPreviousMonth),
                'commercial' => $this->reportReserves($reservesPreviousMonth, 'c'),
                'residential' => $this->reportReserves($reservesPreviousMonth, 'r')
            ],
            'current_month' => [
                'month_name' => $this->getMonthInFull($this->initDateCurrentMonth($this->yearReport, $this->monthReport)),
                'total' => $this->reportTotalReserves($reservesMonth),
                'commercial' => $this->reportReserves($reservesMonth, 'c'),
                'residential' => $this->reportReserves($reservesMonth, 'r'),
                'per_user' => $this->reservesRegisterPerSector($reservesMonth)
            ],
            'current_month_canceled' => [
                'month_name' => $this->getMonthInFull($this->initDateCurrentMonth($this->yearReport, $this->monthReport)),
                'total' => $this->reportTotalReserves($reservesMonthCanceled),
                'commercial' => $this->reportReserves($reservesMonthCanceled, 'c'),
                'residential' => $this->reportReserves($reservesMonthCanceled, 'r'),
                'per_user' => $this->reservesRegisterPerSector($reservesMonthCanceled)
            ],
            'current_month_signed' => [
                'month_name' => $this->getMonthInFull($this->initDateCurrentMonth($this->yearReport, $this->monthReport)),
                'total' => $this->reportTotalReserves($reservesMonthSigned),
                'commercial' => $this->reportReserves($reservesMonthSigned, 'c'),
                'residential' => $this->reportReserves($reservesMonthSigned, 'r'),
                'per_user' => $this->reservesRegisterPerSector($reservesMonthSigned)
            ],
            'next_month' => [
                'month_name' => $this->getMonthInFull($this->initDateCurrentMonth($this->yearReport, $nextMonth)),
                'total' => $this->reportTotalReserves($reservesNextMonth),
                'commercial' => $this->reportReserves($reservesNextMonth, 'c'),
                'residential' => $this->reportReserves($reservesNextMonth, 'r')
            ]
        ];
    }

    /**
     * @param array $dataCancel
     * @return mixed
     * Relatório quantitativo de reservas canceladas
     */
    public function reasonsCancel(array $dataCancel)
    {
        $uniqueReasonCancel = collect($dataCancel)->unique('id_reason_cancel')->toArray();
        $collectionTotal = collect($dataCancel);

        sort($uniqueReasonCancel);
        $canceled = [];

        foreach ($uniqueReasonCancel as $key => $item) {

            if ($item['id_reason_cancel']) {
                $dataReasonCancel = $this->reasonCancelServiceCrud->find($item['id_reason_cancel'])->reason;
            } else {
                $dataReasonCancel = 'N/C';
            }

            $collectionReason = collect($dataCancel)->where('id_reason_cancel', $item['id_reason_cancel']);

            $canceled[$key] = [
                'reason' => $dataReasonCancel,
                'qt' => $collectionReason->count(),
                'value' => $collectionReason->sum('value_negotiated'),
                'percent' =>  !$collectionTotal->count() ? 0 : round(($collectionReason->count() / $collectionTotal->count()) * 100, 2),
                'commercial' => $collectionReason->where('type_location', 'c')->count(),
                'residential' => $collectionReason->where('type_location', 'r')->count()
            ];
        }

        /*
         * Total
         */
        $reportTotal = [
            'reason' => 'total',
            'qt' => $collectionTotal->count(),
            'value' => $collectionTotal->sum('value_negotiated'),
            'residential' => [
                'qt' => $collectionTotal->where('type_location', 'r')->count(),
                'value' => $collectionTotal->where('type_location', 'r')->sum('value_negotiated'),
                'percent' =>  !$collectionTotal->count() ? 0 : round(($collectionTotal->where('type_location', 'r')->count() / $collectionTotal->count()) * 100, 2)
            ],
            'commercial' => [
                'qt' => $collectionTotal->where('type_location', 'c')->count(),
                'value' => $collectionTotal->where('type_location', 'c')->sum('value_negotiated'),
                'percent' =>  !$collectionTotal->count() ? 0 : round(($collectionTotal->where('type_location', 'c')->count() / $collectionTotal->count()) * 100, 2)
            ]
        ];

        /*
         * Sorted Data
         */
        $sort = collect($canceled);
        $sorted = $sort->sortByDesc('qt');
        $reportPerReason = $sorted->values()->all();
        return [
            'per_reason' => $reportPerReason,
            'total' => $reportTotal,
            'per_user' => $this->totalContractPerUser($dataCancel)
        ];
    }

    /**
     * Reservas de meses anteriores
     * @return mixed
     */
    private function reservePreviousMonth()
    {
        $closure = function ($query) {
            return $query->whereBetween('date_reserve', [$this->init_date_system, $this->endDatePreviousMonth($this->yearReport, $this->monthReport)])
                ->whereIn('situation', ['p', 'a', 'r'])
                ->orWhere(function ($query) {
                    $query->whereBetween('date_reserve', [$this->init_date_system, $this->endDatePreviousMonth($this->yearReport, $this->monthReport)])
                        ->whereBetween('conclusion', [$this->initDateCurrentMonth($this->yearReport, $this->monthReport), $this->endDateCurrentMonth($this->yearReport, $this->monthReport)]);
                })
                ->orWhere(function ($query) {
                    $query->whereBetween('date_reserve', [$this->init_date_system, $this->endDatePreviousMonth($this->yearReport, $this->monthReport)])
                        ->whereBetween('conclusion', [$this->initDateNextMonth($this->yearReport, $this->monthReport), $this->end_date_system]);
                });
        };

        return $this->contractServiceCrud->scopeQuery($closure);
    }

    /**
     * Reservas do mês
     */
    private function reservesMonth()
    {
        $closure = function($query) {
            return $query->whereBetween('date_reserve', [$this->initDateCurrentMonth($this->yearReport, $this->monthReport), $this->endDateCurrentMonth($this->yearReport, $this->monthReport)]);
        };

        return $this->contractServiceCrud->scopeQuery($closure);
    }

    /**
     * Reservas do mês canceladas
     */
    private function reservesMonthCanceled()
    {
        $closure = function($query) {
            return $query->whereBetween('end_process', [$this->initDateCurrentMonth($this->yearReport, $this->monthReport), $this->endDateCurrentMonth($this->yearReport, $this->monthReport)])
                ->whereIn('situation', ['c']);
        };

        return $this->contractServiceCrud->scopeQuery($closure);
    }

    /**
     * Reservas do mês assinadas
     */
    private function reserveSigned()
    {
        $closure = function ($query) {
            return $query->whereBetween('conclusion', [$this->initDateCurrentMonth($this->yearReport, $this->monthReport), $this->endDateCurrentMonth($this->yearReport, $this->monthReport)])
                ->whereIn('situation', ['as', 'ap', 'af']);
        };

        return $this->contractServiceCrud->scopeQuery($closure);
    }

    /**
     * Reservas próximo mês
     */
    private function reserveNextMonth()
    {
        $closure = function ($query) {
            return $query->whereIn('situation', ['r', 'd', 'a', 'cd', 'p'])
                ->orWhere(function ($query) {
                    $query->whereBetween('date_reserve', [$this->initDateNextMonth($this->yearReport, $this->monthReport), $this->end_date_system]);
                });
        };

        return $this->contractServiceCrud->scopeQuery($closure);
    }

    /**
     * Total de reservas
     * @param $data
     * @return array
     */
    private function reportTotalReserves($data) : array
    {
        $collection = collect($data);

        return [
            'qt' => $collection->count(),
            'value' => $collection->sum('value_negotiated')
        ];
    }

    /**
     * Reserves de acordo o tipo de locação
     * @param $data
     * @param string $typeLocation
     * @return array
     */
    private function reportReserves($data, string $typeLocation) : array
    {
        $totalReserves = $this->reportTotalReserves($data);
        $collection = collect($data);
        $reserves = $collection->where('type_location', $typeLocation);

        return [
            'qt' => $reserves->count(),
            'value' => $reserves->sum('value_negotiated'),
            'percent' =>  !$totalReserves['qt'] ? 0 : round(($reserves->count() / $totalReserves['qt']) * 100, 2)
        ];

    }

    /**
     * Divide a reserva por setor e responsável
     * @param $data
     * @return array
     */
    private function reservesRegisterPerSector($data) : array
    {
        $collection = collect($data);
        $total = $collection->count();
        $users_register_sector = [];
        $users_reception_sector = [];

        $usersRegisterSector = $this->getUsers($data, 'attendant_register_id');
        $usersReceptionSector = $this->getUsers($data, 'attendant_reception_id');

        /*
         * reservas usuários setor cadastro
         */
        foreach ($usersRegisterSector as $key => $user) {
            $collectionUser =  $collection->where('attendant_register_id', $user['id']);
            $users_register_sector[$key] = [
                'name' => $user['name'],
                'qt' => $collectionUser->count(),
                'value' => $collectionUser->sum('value_negotiated'),
                'percent' =>  !$total ? 0 : round(($collectionUser->count() / $total) * 100, 2)
            ];
        }

        /*
         * reservas usuários setor recepção
         */
        foreach ($usersReceptionSector as $key => $user) {
            $collectionUser =  $collection->where('attendant_reception_id', $user['id']);
            $users_reception_sector[$key] = [
                'name' => $user['name'],
                'qt' => $collectionUser->count(),
                'value' => $collectionUser->sum('value_negotiated'),
                'percent' =>  !$total ? 0 : round(($collectionUser->count() / $total) * 100, 2)
            ];
        }

        $users = [
            'users_register_sector' => $users_register_sector,
            'users_reception_sector' => $users_reception_sector,
        ];

        return $users;
    }

    private function getUsers($data, string $keyUnique) : array
    {
        $collection = collect($data);
        $unique = $collection->unique($keyUnique)->all();
        $user = [];
        foreach ($unique as $key => $item) {
            $userData = $this->userServiceCrud->find($item[$keyUnique], false);
            $user[$key] = [
                'id' => $item[$keyUnique],
                'name' => $userData->name . ' ' . $userData->last_name
            ];
        }

        if(count($user)) {
            sort($user);
            return $this->sort($user, 'name');
        }

        return $user;
    }

    private function sort(array $data, string $sortBy)
    {
        $sort = collect($data);
        $sorted = $sort->sortBy($sortBy);
        return $sorted->values()->all();
    }
}