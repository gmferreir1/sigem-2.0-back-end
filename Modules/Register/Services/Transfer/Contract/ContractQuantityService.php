<?php

namespace Modules\Register\Services\Transfer\Contract;


class ContractQuantityService
{
    /**
     * @var ContractService
     */
    private $contractService;

    public function __construct(ContractService $contractService)
    {
        $this->contractService = $contractService;
    }

    public function getReportQt(array $data)
    {
        return [
            'total' => $this->getReportTotal($data),
            'per_user' => $this->getReportPerUser($data),
            'reasons' => $this->reasons($data)
        ];
    }

    private function getReportTotal(array $data)
    {
        $collection = collect($data);

        $report = [
            'name' => 'total',
            'qt' => $collection->count(),
            'value' => $collection->sum('value')
        ];

        return $report;
    }

    private function getReportPerUser(array $data)
    {
        $report = [];
        $collection = collect($data);
        $users = $this->contractService->getAllResponsible();

        foreach ($users as $key => $item) {
            $userCollection = $collection->where('responsible_transfer_id', $item['id']);
            $percent = $collection->count() == 0 ? 0 : round(($userCollection->count() * 100) / $collection->count());

            $report[$key] = [
                'name' => $item['name'],
                'qt' => $userCollection->count(),
                'value' => $userCollection->sum('value'),
                'percent' => $percent
            ];
        }

        return $this->sortBy($report, 'name', 'asc');
    }

    private function reasons(array $data)
    {
        $allReasons = collect($data)->unique('reason_id')->values();
        $collection = collect($data);
        $reasons = [];
        $report = [];

        foreach ($allReasons as $key => $allReasonData) {
            $reasons[$key] = [
                'id' => $allReasonData['reason_id'],
                'name' => $allReasonData['reason_name']
            ];
        }

        foreach ($reasons as $key => $reason) {

            $reasonCollect = collect($data)->where('reason_id', $reason['id']);

            $percent = $collection->count() == 0 ? 0 : round(($reasonCollect->count() * 100) / $collection->count());

            $report[$key] = [
                'name' => $reason['name'],
                'qt' => $reasonCollect->count(),
                'percent' => $percent,
                'value' => $reasonCollect->sum('value'),
            ];
        }

        return $this->sortBy($report, 'qt');
    }

    private function sortBy(array $data, string $sortBy, string $orderSort = null)
    {
        $dataSorted = collect($data);
        if (!$orderSort) {
            return $dataSorted->sortByDesc($sortBy)->values()->all();
        }

        return $dataSorted->sortBy($sortBy)->values()->all();

    }
}