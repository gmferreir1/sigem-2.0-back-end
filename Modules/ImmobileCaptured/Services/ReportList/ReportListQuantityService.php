<?php

namespace Modules\ImmobileCaptured\Services\ReportList;


class ReportListQuantityService
{
    /**
     * @var ReportListServiceCrud
     */
    private $serviceCrud;

    public function __construct(ReportListServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    public function getReportListQuantity(array $data)
    {
        return [
            'resume_total' => [
                'total' => $this->getTotal($data),
                'residential' => $this->getTotal($data, 'r'),
                'commercial' => $this->getTotal($data, 'nr')
            ],
            'resume_per_user' => $this->getTotalPerResponsible($data)
        ];
    }

    private function getTotal(array $data, string $typeLocation = null, int $responsible = null)
    {
        if ($responsible) {
            $collection = collect($data)->where('responsible', $responsible);
        } else {
            $collection = collect($data);
        }

        $values = $typeLocation ? $collection->where('type_location', $typeLocation) : $values = $collection;

        return [
            'total_qt' => $values->count(),
            'total_values' => $values->sum('value'),
            'percent' =>  $typeLocation ? $collection->count() == 0 ? 0 : round(($values->sum('value') * 100) / $collection->sum('value')) : null
        ];
    }

    private function getTotalPerResponsible(array $data)
    {
        $collection = collect($data)->unique('responsible')->sortBy('responsible_name')->values()->all();
        $users = [];

        foreach ($collection as $key => $item) {
            $users[$key] = [
                'name' => $item['responsible_name'],
                'resume_total' => [
                    'total' => $this->getTotal($data, null, $item['responsible']),
                    'residential' => $this->getTotal($data, 'r', $item['responsible']),
                    'commercial' => $this->getTotal($data, 'nr', $item['responsible'])
                ]
            ];
        }

        return $users;
    }
}