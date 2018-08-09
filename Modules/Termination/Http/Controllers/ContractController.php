<?php

namespace Modules\Termination\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Sicadi\Services\QueryService;
use Modules\Termination\Presenters\HistoricPresenter;
use Modules\Termination\Services\ContractReportService;
use Modules\Termination\Services\ContractService;
use Modules\Termination\Services\ContractServiceCrud;
use Modules\Termination\Services\HistoricServiceCrud;
use Modules\Termination\Services\PrintService;
use Modules\Termination\Services\RentAccessoryServiceCrud;
use Modules\Termination\Services\ScoreService;

class ContractController extends Controller
{

    /**
     * @var ContractServiceCrud
     */
    protected $serviceCrud;
    /**
     * @var ContractService
     */
    private $service;
    /**
     * @var QueryService
     */
    private $queryService;
    /**
     * @var HistoricServiceCrud
     */
    private $historicServiceCrud;
    /**
     * @var RentAccessoryServiceCrud
     */
    private $rentAccessoryServiceCrud;
    /**
     * @var ScoreService
     */
    private $scoreService;
    /**
     * @var PrintService
     */
    private $printService;
    /**
     * @var ContractReportService
     */
    private $contractReportService;


    public function __construct(ContractServiceCrud $serviceCrud, ContractService $service, RentAccessoryServiceCrud $rentAccessoryServiceCrud
                                , QueryService $queryService, HistoricServiceCrud $historicServiceCrud, ScoreService $scoreService, PrintService $printService
                                , ContractReportService $contractReportService)
    {
        $this->serviceCrud = $serviceCrud;
        $this->service = $service;
        $this->rentAccessoryServiceCrud = $rentAccessoryServiceCrud;
        $this->queryService = $queryService;
        $this->historicServiceCrud = $historicServiceCrud;
        $this->scoreService = $scoreService;
        $this->printService = $printService;
        $this->contractReportService = $contractReportService;
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $dataToCreate = $request->all();

        // verifica se o contrato jã não esta lançado
        $checkContract = $this->checkContractAlreadyRelease($dataToCreate['contract']);

        if ($checkContract['error']) {
            $message[] = "Contrato já lançado no sistema";
            return response($message, 422);
        }

        // limpa os campos não utilizados
        $dataToCreate = $this->service->cleanFields($dataToCreate);

        // valida campos condicionais
        $checkFields = $this->service->validadeFields($dataToCreate);
        if ($checkFields) {
            return $checkFields;
        }

        $dataToCreate['rp_last_action'] = Auth::user()->id;

        $dataCreated = $this->serviceCrud->create($dataToCreate);

        if (!isset($dataCreated->id)) {
            return $dataCreated;
        }

        // cria acessorios da locação
        $this->rentAccessoryServiceCrud->create(['termination_id' => $dataCreated->id, 'rp_last_action' => Auth::user()->id], false);

        // grava o histórico
        $type = $dataCreated->type_register === 'termination' ? 'inativação' : 'transferencia';
        $this->historicServiceCrud->createHistoric("abriu a $type", $dataCreated->id, 'system_action');

        // adiciona mais um score para o rp_per_inactive
        $this->scoreService->addScore($dataCreated->rp_per_inactive);

        return $dataCreated;
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
        $dataBeforeUpdate = $this->serviceCrud->find($id);

        $checkStatusAllowUpdate = $this->service->checkStatusAllowUpdate($dataToUpdate['id']);
        if ($checkStatusAllowUpdate) {
            return $checkStatusAllowUpdate;
        }

        // limpa os campos não utilizados
        $dataToUpdate = $this->service->cleanFields($dataToUpdate);

        // valida campos condicionais
        $checkFields = $this->service->validadeFields($dataToUpdate);
        if ($checkFields) {
            return $checkFields;
        }

        $dataUserLogged = Auth::user();

        // grava historico
        if (isset($dataToUpdate['historic']) && $dataToUpdate['historic']) {
            $dataHistoric = [
                'contract_id' => $id,
                'historic' => $dataToUpdate['historic'],
                'rp_last_action' => $dataUserLogged->id,
                'type_action' => 'user_action'
            ];

            $this->historicServiceCrud->create($dataHistoric, false);
        }


        // historico de alterações
        $messages = $this->service->checkChangesForMessageHistoric($dataBeforeUpdate->toArray(), $dataToUpdate);
        foreach ($messages as $message) {
            $dataHistoric = [
                'contract_id' => $id,
                'historic' => $message,
                'rp_last_action' => $dataUserLogged->id,
                'type_action' => 'system_action'
            ];

            $this->historicServiceCrud->create($dataHistoric, false);
        }

        return $this->serviceCrud->update($dataToUpdate, $id);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function all(Request $request)
    {
        $queryParams = [
            'init_date' => $request->get('init_date'),
            'end_date' => $request->get('end_date'),
            'status' => $request->get('status'),
            'type_register' => $request->get('type_register'),
            'responsible' => $request->get('responsible'),
            'date_conclusion' => $request->get('date_conclusion') === 'false' ? false : true,
            'sort_by' => $request->get('sort_by'),
            'sort_order' => $request->get('sort_order') == 'false' ? 'DESC' : 'ASC',
            'printer' => $request->get('printer') === 'false' ? false : true,
            'type_printer' => $request->get('type_printer')
        ];

        $filter = $this->service->mountFilter($queryParams);

        $results = $this->serviceCrud->getAll($filter, $queryParams['printer']);

        if (!$queryParams['printer']) {
            return $results;
        }

        // print data
        $results['extra_data']['report_data'] = $this->contractReportService->getReportData($results['data']);
        $results['extra_data']['destinations'] = $this->contractReportService->getDestinations($results['data']);
        $results['extra_data']['reasons'] = $this->contractReportService->getReasons($results['data']);
        $results['extra_data']['survey'] = $this->contractReportService->getSurvey($results['data']);
        $results['extra_data']['responsible_select'] = count($filter['responsible']) > 1 ? 'multipla selecao' : $this->service->getNameUser($filter['responsible'][0]);
        $results['extra_data']['period'] = (!$queryParams['init_date'] || !$queryParams['end_date']) ? 'GERAL' : $queryParams['init_date'] . ' a ' . $queryParams['end_date'];
        $results['extra_data']['type_record'] = $queryParams['type_printer'];

        return $this->printService->callPrinter($results, 'termination::printer.listContractInactive', 'landscape');
    }


    /**
     * Retorna todos os responsáveis com inativações no nome
     */
    public function getAllResponsible()
    {
        return $this->service->getAllResponsible();
    }

    /**
     * Verifica se o contrato esta cadastrado no sistema
     * @param $contract
     * @return array
     */
    public function checkContractAlreadyRelease($contract)
    {
        $closure = function ($query) use ($contract) {
            return $query->where('contract', $contract)
                        ->whereNotIn('status', ['c']);
        };

        $check = $this->serviceCrud->scopeQuery($closure);

        if ($check->count()) {
            return [
                'error' => true,
                'message' => 'contract already registered'
            ];
        }

        return [
            'error' => false
        ];
    }

    /**
     * Consulta fiadores do contrato
     * @param Request $request
     * @return array
     */
    public function getGuarantorsContract(Request $request)
    {
        $queryParams = [
            'contract' => $request->get('contract')
        ];

        return $this->queryService->getGuarantors($queryParams['contract']);
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
     * Pega historico da inativação
     * @param $contractId
     * @return mixed
     */
    public function getHistoric($contractId)
    {
        $closure = function ($query) use ($contractId) {
            return $query->where('contract_id', $contractId)
                        ->orderBy('id', 'DESC');
        };

        return $this->historicServiceCrud->scopeQuery($closure, false, 0, HistoricPresenter::class);
    }

    /**
     * Retorna o ultimo e o penultimo atendimento
     */
    public function getLastAttendances()
    {
        return $this->service->getLastAttendances();
    }
}
