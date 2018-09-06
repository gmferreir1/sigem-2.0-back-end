<?php

namespace Modules\ImmobileCaptured\Services\ReportList;


use Modules\ImmobileCaptured\Presenters\ReportList\ReportListPresenter;

class ReportListService
{
    /**
     * @var ReportListServiceCrud
     */
    private $serviceCrud;

    public function __construct(ReportListServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    /**
     * @return array
     */
    public function queryResponsible()
    {
        $results = $this->serviceCrud->all(false, 0, ReportListPresenter::class);
        $collection = collect($results['data'])->unique('responsible')->values()->all();
        $users = [];

        foreach ($collection as $key => $item) {
            $users[$key] = [
                'id' => $item['responsible'],
                'name' => $item['responsible_name']
            ];
        }

        return $this->sort($users, 'name');
    }

    /**
     * Retorna apenas os ids dos responsaveis
     * @return array
     */
    public function onlyIdResponsible() : array
    {
        $allResponsible = $this->queryResponsible();
        $idsResponsible = [];

        if (!count($allResponsible)) return [];

        foreach ($allResponsible as $item) {
            array_push($idsResponsible, $item['id']);
        }

        return $idsResponsible;
    }

    /**
     * Verifica se o usuário esta alterando somente a captação do mês
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function checkCapturedCurrentMonth(int $id)
    {
        $capturedData = $this->serviceCrud->find($id);

        $monthCurrent = date('m');
        $yearCurrent = date('Y');

        $monthCaptured = date('m', strtotime($capturedData->captured_date));
        $yearCaptured = date('Y', strtotime($capturedData->captured_date));

        if ($monthCurrent != $monthCaptured || $yearCurrent != $yearCaptured) {
            $message[] = "Alterações somente de captações do mês corrente";
            return response($message, 422);
        }
    }

    /**
     * @param array $data
     * @param string $sortBy
     * @param string $sortOrder
     * @return mixed
     */
    public function sort(array $data, string $sortBy, string $sortOrder = 'ASC')
    {
        $dataSort = collect($data);

        if ($sortOrder === 'ASC') {
            return $dataSort->sortBy($sortBy)->values()->all();
        }

        return $dataSort->sortByDesc($sortBy)->values()->all();
    }
}