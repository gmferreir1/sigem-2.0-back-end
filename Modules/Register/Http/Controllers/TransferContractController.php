<?php

namespace Modules\Register\Http\Controllers;

use App\Traits\Generic\DateTime;
use App\Traits\Generic\Printer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Register\Presenters\Transfer\Contract\ContractPresenter;
use Modules\Register\Presenters\Transfer\Historic\HistoricPresenter;
use Modules\Register\Services\Transfer\Contract\ContractQuantityService;
use Modules\Register\Services\Transfer\Contract\ContractService;
use Modules\Register\Services\Transfer\Contract\ContractServiceCrud;
use Modules\Register\Services\Transfer\Historic\HistoricService;
use Modules\Register\Services\Transfer\Historic\HistoricServiceCrud;
use Modules\Register\Services\Transfer\ScoreAttendant\ScoreAttendantService;

class TransferContractController extends Controller
{
    use Printer;

    use DateTime;

    /**
     * @var ContractServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ContractService
     */
    private $service;
    /**
     * @var ContractQuantityService
     */
    private $quantityService;
    /**
     * @var HistoricServiceCrud
     */
    private $historicServiceCrud;
    /**
     * @var HistoricService
     */
    private $historicService;
    /**
     * @var ScoreAttendantService
     */
    private $scoreAttendantService;

    public function __construct(ContractServiceCrud $serviceCrud, ContractService $service, ContractQuantityService $quantityService
                                , HistoricServiceCrud $historicServiceCrud, HistoricService $historicService, ScoreAttendantService $scoreAttendantService)
    {
        $this->serviceCrud = $serviceCrud;
        $this->service = $service;
        $this->quantityService = $quantityService;
        $this->historicServiceCrud = $historicServiceCrud;
        $this->historicService = $historicService;
        $this->scoreAttendantService = $scoreAttendantService;
    }

    /**
     * Verifica se o contrato esta lançado no sistema
     * @param Request $request
     * @return mixed
     */
    public function queryContractIsRelease(Request $request)
    {
        $contract = $request->get('contract');
        return $this->service->checkContractIsRelease($contract);
    }

    /**
     * Retorna todos os responsáveis
     * @return array
     */
    public function getAllResponsible()
    {
        return $this->service->getAllResponsible();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function all(Request $request)
    {

        $queryParams = [
            'sort_by' => $request->get('sort_by'),
            'sort_order' => $request->get('sort_order') === 'false' ? 'desc' : 'asc',
            'status' => $request->get('status') ? $request->get('status') : array('p'),
            'responsible_contract_transfer' => $request->get('responsible_contract_transfer') ? $request->get('responsible_contract_transfer') : $this->service->getAllResponsibleForFilter(),
            'init_date' => $request->get('init_date') ? Carbon::createFromFormat('d/m/Y', $request->get('init_date'))->format('Y-m-d') : $this->init_date_system,
            'end_date' => $request->get('end_date') ? Carbon::createFromFormat('d/m/Y', $request->get('end_date'))->format('Y-m-d') : $this->end_date_system,
            'search_for_conclusion_date' => $request->get('search_for_conclusion_date') === 'true' ? true : false,
            'printer' => $request->get('printer') === 'true' ? true : false
        ];



        // pesquisa pela data de transferencia
        if (!$queryParams['search_for_conclusion_date']) {

            $closure = function ($query) use ($queryParams) {
                return $query->whereIn('responsible_transfer_id', $queryParams['responsible_contract_transfer'])
                    ->whereIn('status', $queryParams['status'])
                    ->whereBetween('transfer_date', array($queryParams['init_date'], $queryParams['end_date']))
                    ->orderBy('transfer_date', 'DESC');
            };

        }
        // pesquisa pela data da finalização do processo
        else {
            $closure = function ($query) use ($queryParams) {
                return $query->whereIn('responsible_transfer_id', $queryParams['responsible_contract_transfer'])
                    ->whereIn('status', $queryParams['status'])
                    ->whereBetween('end_process', array($queryParams['init_date'], $queryParams['end_date']))
                    ->orderBy('end_process', 'DESC');
            };
        }


        $results = $this->serviceCrud->scopeQuery($closure, false, 0, ContractPresenter::class);

        $results['data'] = $this->service->sort($results['data'], $queryParams['sort_by'], $queryParams['sort_order']);

        if ($queryParams['printer']) {
            $results['period'] = 'Geral';
            $results['report_qt'] = $this->quantityService->getReportQt($results['data']);
            $viewName = 'register::transfer.printer.ListContractTransfer';
            return $this->printer($results, $viewName, 'landscape');
        }

        return $results;
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

        /*
         * Verifica se o contrato esta lançado no sistema
         */
        $check = $this->service->checkContractIsRelease($dataToSave['contract']);
        if ($check) return $check;


        /*
         * Custom validade
         */
        $check = $this->service->customValidade($dataToSave);
        if ($check) return $check;


        $dataSaved = $this->serviceCrud->create($dataToSave);

        if (!isset($dataSaved->id)) {
            return $dataSaved;
        }

        /*
         * Gravo mais um no score de atendimento para o responsável da transferencia
         */
        $this->scoreAttendantService->addScore($dataToSave['responsible_transfer_id']);


        /*
         * Historico da ação
         */
        $this->historicService->actionCreate($dataSaved->id);

        /*
         * Grava historico
         */
        if ($dataToSave['historic_data']['historic']) {
            $dataHistoricCreate = [
                'historic' => $dataToSave['historic_data']['historic'],
                'rp_last_action' => Auth::user()->id,
                'transfer_id' => $dataSaved->id
            ];

            $this->historicServiceCrud->create($dataHistoricCreate);
        }

        return $dataSaved;
    }

    public function find($id)
    {
        $transferContract = $this->serviceCrud->find($id);

        $closure = function ($query) use ($transferContract) {
            return $query->where('transfer_id', $transferContract->id)
                        ->orderBy('id', 'DESC');
        };

        $historicTransfer = $this->historicServiceCrud->scopeQuery($closure, false, 0, HistoricPresenter::class);

        return [
            'transfer' => $transferContract,
            'historic' => count($historicTransfer['data']) ? $historicTransfer['data'] : null
        ];
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $dataToUpdate = $request->all();
        $dataToUpdate['rp_last_action'] = Auth::user()->id;

        $dataBeforeUpdate = $this->serviceCrud->find($id);

       /*
        * Custom validade
        */
        $check = $this->service->customValidade($dataToUpdate, $dataBeforeUpdate->toArray());
        if ($check) return $check;

        $dataToUpdate['end_process'] = ($dataToUpdate['status'] == 'c' || $dataToUpdate['status'] == 'r') ? date('Y-m-d') : null;
        $dataUpdated = $this->serviceCrud->update($dataToUpdate, $id);
        if (!isset($dataUpdated->id)) {
            return $dataUpdated;
        }

        /*
         * Score transaction
         * Se o usuário alterar o responsavel pela transferencia(subtrai de um e soma de outro responsável)
         */
        if ($dataToUpdate['responsible_transfer_id'] != $dataBeforeUpdate['responsible_transfer_id']) {
            $this->scoreAttendantService->scoreTransaction($dataBeforeUpdate['responsible_transfer_id'], $dataToUpdate['responsible_transfer_id']);
        }


       /*
        * Grava historico
        */
        if ($dataToUpdate['historic_data']['historic']) {
            $dataHistoricCreate = [
                'historic' => $dataToUpdate['historic_data']['historic'],
                'rp_last_action' => Auth::user()->id,
                'transfer_id' => $id
            ];

            $this->historicServiceCrud->create($dataHistoricCreate);
        }


        /*
         * Historico da ação
         */
        $this->historicService->actionUpdate($dataToUpdate, $dataBeforeUpdate->toArray(), $id);


        return $dataUpdated;
    }
}
