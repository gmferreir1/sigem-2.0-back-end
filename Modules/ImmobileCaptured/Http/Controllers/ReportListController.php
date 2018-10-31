<?php

namespace Modules\ImmobileCaptured\Http\Controllers;

use App\Traits\Generic\DateTime;
use App\Traits\Generic\Printer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\ImmobileCaptured\Presenters\ReportList\ReportListPresenter;
use Modules\ImmobileCaptured\Services\ReportList\ReportListQuantityService;
use Modules\ImmobileCaptured\Services\ReportList\ReportListService;
use Modules\ImmobileCaptured\Services\ReportList\ReportListServiceCrud;

class ReportListController extends Controller
{
    use DateTime;
    /**
     * @var ReportListServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ReportListService
     */
    private $service;
    /**
     * @var ReportListQuantityService
     */
    private $quantityService;

    use Printer;

    public function __construct(ReportListServiceCrud $serviceCrud, ReportListService $service, ReportListQuantityService $quantityService)
    {
        $this->serviceCrud = $serviceCrud;
        $this->service = $service;
        $this->quantityService = $quantityService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function queryImmobileIsRelease(Request $request)
    {
        $queryParams = [
            'immobile_code' => $request->get('immobile_code')
        ];

        $check = $this->serviceCrud->findWhere($queryParams);

        if ($check->count()) {
            $message[] = "Código já lançado no sistema";
            return response($message, 422);
        }
    }

    /**
     * Retorna os responsáveis pela captações
     * @return array
     */
    public function queryResponsible()
    {
        return $this->service->queryResponsible();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function save(Request $request)
    {
        $dataToSave = $request->all();
        $dataToSave['rp_last_action'] = Auth::user()->id;

        return $this->serviceCrud->create($dataToSave);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->serviceCrud->find($id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function all(Request $request)
    {
        $queryParams = [
            'init_date' => !$request->get('init_date') ? $this->init_date_system : Carbon::createFromFormat('d/m/Y', $request->get('init_date'))->format('Y-m-d'),
            'end_date' => !$request->get('end_date') ? $this->end_date_system : Carbon::createFromFormat('d/m/Y', $request->get('end_date'))->format('Y-m-d'),
            'type_location' => !$request->get('type_location') ? array('r', 'nr') : $request->get('type_location'),
            'responsible' => !$request->get('responsible') ? $this->service->onlyIdResponsible() : $request->get('responsible'),
            'print' => $request->get('print') == 'true' ? true : false
        ];


        $closure = function ($query) use ($queryParams) {
            return $query->whereBetween('captured_date', array($queryParams['init_date'], $queryParams['end_date']))
                        ->whereIn('responsible', $queryParams['responsible'])
                        ->whereIn('type_location', $queryParams['type_location'])
                        ->orderBy('captured_date', 'DESC');
        };

        $results = $this->serviceCrud->scopeQuery($closure, false, 0, ReportListPresenter::class);

        if ($queryParams['print']) {

            $results['period'] = ($queryParams['init_date'] == $this->init_date_system || $queryParams['end_date'] == $this->end_date_system) ? 'Geral' : $request->get('init_date') . ' a ' . $request->get('end_date');
            $results['report_qt'] = $this->quantityService->getReportListQuantity($results['data']);


            return $this->printer($results, 'immobilecaptured::printer.reportList.ListImmobileCaptured', 'landscape');
        } else {
            return $results;
        }
    }

    /**
     * @param $id
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function delete($id)
    {
        $checkBeforeDelete = $this->service->checkCapturedCurrentMonth($id);

        if ($checkBeforeDelete) return $checkBeforeDelete;

        $this->serviceCrud->delete($id);

        return [
            'success' => true
        ];
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $dataToUpdate = $request->all();
        $dataToUpdate['rp_last_action'] = Auth::user()->id;

        $checkBeforeUpdate = $this->service->checkCapturedCurrentMonth($id);
        if ($checkBeforeUpdate) return $checkBeforeUpdate;

        return $this->serviceCrud->update($dataToUpdate, $id);
    }
}
