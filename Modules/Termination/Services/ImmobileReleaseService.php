<?php

namespace Modules\Termination\Services;


use App\Traits\Generic\DateTime;
use Carbon\Carbon;
use Modules\Termination\Presenters\ImmobileReleaseForFilterPresenter;

class ImmobileReleaseService
{
    use DateTime;

    /**
     * @var ImmobileReleaseServiceCrud
     */
    private $serviceCrud;

    public function __construct(ImmobileReleaseServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    /**
     * Retorna todos os responsaveis
     * @return array
     */
    public function getAllResponsible() : array
    {
        $allData = $this->serviceCrud->all(false, 0, ImmobileReleaseForFilterPresenter::class);

        if (!count($allData['data'])) {
            return [];
        }

        $collection = collect($allData['data']);
        $rps = $collection->unique('rp_receive')->values()->all();
        $responsible = [];

        foreach ($rps as $key => $item) {

            $responsible[$key] = [
                'id' => $item['rp_receive'],
                'name' => $item['rp_receive_name']
            ];
        }

        return count($responsible) ? $this->sort($responsible, 'name') : $responsible;
    }


    public function mountFilter(array $filter)
    {
        if (count($filter['responsible']) || !$filter['responsible']) {

            $allResponsible = $this->getAllResponsible();

            if (!count($allResponsible)) {
                $filter['responsible'] = [];
            } else {
                foreach ($allResponsible as $key => $item) {
                    $filter['responsible'][$key] = $item['id'];
                }
            }
        }

        if (!$filter['init_date'] || !$filter['end_date']) {
            $filter['init_date'] = $this->init_date_system;
            $filter['end_date'] = $this->end_date_system;
        } else {
            $filter['init_date'] = Carbon::createFromFormat('d/m/Y', $filter['init_date'])->format('Y-m-d');
            $filter['end_date'] = Carbon::createFromFormat('d/m/Y', $filter['end_date'])->format('Y-m-d');
        }

        if (!$filter['status'] || !count($filter['status'])) {
            $filter['status'] = array('p');
        }

        return $filter;
    }


    private function sort(array $data, string $sortBy)
    {
        $dataSorted = collect($data);

        return $dataSorted->sortBy($sortBy)->values()->all();
    }
}