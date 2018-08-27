<?php

namespace Modules\Register\Http\Controllers;

use App\Traits\Generic\DateTime;
use App\Traits\Generic\Printer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Register\Presenters\ReserveContract\ReserveContractListPresenter;
use Modules\Register\Presenters\ReserveContract\ReserveContractPresenter;
use Modules\Register\Presenters\ReserveHistoric\ReserveHistoricPresenter;
use Modules\Register\Services\ReserveContract\ReserveContractCustomValidadeService;
use Modules\Register\Services\ReserveContract\ReserveContractPrinterService;
use Modules\Register\Services\ReserveContract\ReserveContractService;
use Modules\Register\Services\ReserveContract\ReserveContractServiceCrud;
use Modules\Register\Services\ReserveHistoric\ReserveHistoricService;
use Modules\Register\Services\ReserveHistoric\ReserveHistoricServiceCrud;
use Modules\Register\Services\ScoreAttendance\ScoreAttendanceService;

class ReserveContractController extends Controller
{
    use Printer;

    use DateTime;
    /**
     * @var ReserveContractServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ReserveContractService
     */
    private $service;
    /**
     * @var ScoreAttendanceService
     */
    private $scoreAttendanceService;
    /**
     * @var ReserveHistoricService
     */
    private $reserveHistoricService;
    /**
     * @var ReserveHistoricServiceCrud
     */
    private $reserveHistoricServiceCrud;
    /**
     * @var ReserveContractCustomValidadeService
     */
    private $reserveContractCustomValidadeService;
    /**
     * @var ReserveContractPrinterService
     */
    private $reserveContractPrinterService;

    public function __construct(ReserveContractServiceCrud $serviceCrud, ReserveContractService $service, ScoreAttendanceService $scoreAttendanceService
                                , ReserveHistoricService $reserveHistoricService, ReserveHistoricServiceCrud $reserveHistoricServiceCrud
                                , ReserveContractCustomValidadeService $reserveContractCustomValidadeService, ReserveContractPrinterService $reserveContractPrinterService)
    {
        $this->serviceCrud = $serviceCrud;
        $this->service = $service;
        $this->scoreAttendanceService = $scoreAttendanceService;
        $this->reserveHistoricService = $reserveHistoricService;
        $this->reserveHistoricServiceCrud = $reserveHistoricServiceCrud;
        $this->reserveContractCustomValidadeService = $reserveContractCustomValidadeService;
        $this->reserveContractPrinterService = $reserveContractPrinterService;
    }

    /**
     * Pega os dados do cliente pelo CPF
     * @param Request $request
     * @return array
     */
    public function getClient(Request $request)
    {
        $queryParams = [
            'client_cpf' => $request->get('client_cpf')
        ];

        $results = $this->serviceCrud->findWhere(['client_cpf' => $queryParams['client_cpf']]);

        if ($results->count()) {
            return [
                'client_name' => $results[0]['client_name'],
                'client_cpf' => $results[0]['client_cpf'],
                'client_rg' => $results[0]['client_rg'],
                'client_profession' => $results[0]['client_profession'],
                'client_company' => $results[0]['client_company'],
                'client_address' => $results[0]['client_address'],
                'client_neighborhood' => $results[0]['client_neighborhood'],
                'client_city' => $results[0]['client_city'],
                'client_state' => $results[0]['client_state'],
                'client_phone_01' => $results[0]['client_phone_01'],
                'client_phone_02' => $results[0]['client_phone_02'],
                'client_phone_03' => $results[0]['client_phone_03'],
                'client_email' => $results[0]['client_email'],
            ];
        }

        return [];
    }

    /**
     * @param Request $request
     * @return null
     */
    public function immobileIsRelease(Request $request)
    {
        $queryParams = [
            'immobile_code' => $request->get('immobile_code')
        ];

        return $this->service->checkReserveIsRelease($queryParams['immobile_code']);
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

        // custom validade
        $customValidade = $this->reserveContractCustomValidadeService->customValidade($dataToSave);
        if ($customValidade) {
            return $customValidade;
        }


        $checkFieldsToSave = $this->service->checkFieldsToSave($dataToSave);

        if ($checkFieldsToSave) {
            return $checkFieldsToSave;
        }

        if (!$dataToSave['force_submit']) {
            /*
             * Verifica se foi lançado no sistema
             */
            if ($this->service->checkReserveIsRelease($dataToSave['immobile_code'])) {
                $message[] = "Imóvel ja lançado em outra reserva";
                return response($message, 422);
            }

        }

        $dataSaved = $this->serviceCrud->create($dataToSave);

        /*
        * Gera o código da reserva
        */
        $dataReserveCode = [
            'code_reserve' => $dataSaved->id,
            'year_reserve' => date('Y')
        ];

        $this->serviceCrud->update($dataReserveCode, $dataSaved->id, false);

        /*
         * Gero score de atendimento
         */
        $this->scoreAttendanceService->addScore($dataSaved->attendant_register_id);

        if (!isset($dataSaved->id)) {
            return $dataSaved;
        }


        /*
         * Grava o historico de abertura
         */
        $this->reserveHistoricService->createReserve($dataSaved->toArray());


        /*
         * Verifica se o usuário ja passou historico
         */
        if ($dataToSave['historic_data']['historic'] && $dataSaved->id) {

            $dataHistoric = [
                'historic' => $dataToSave['historic_data']['historic'],
                'reserve_id' => $dataSaved->id,
                'rp_last_action' => Auth::user()->id,
            ];

            $this->reserveHistoricServiceCrud->create($dataHistoric);
        }

        return $dataSaved;
    }

    public function getResponsibleForFilter()
    {
        return $this->service->getAllResponsible();
    }

    public function all(Request $request)
    {
        $queryParams = [
            'situation' => $request->get('status'),
            'responsible_register_sector' => $request->get('responsible_register_sector'),
            'responsible_reception' => $request->get('responsible_reception'),
            'init_date' => !$request->get('init_date') ? $this->init_date_system : Carbon::createFromFormat('d/m/Y', $request->get('init_date'))->format('Y-m-d'),
            'end_date' => !$request->get('end_date') ? $this->end_date_system : Carbon::createFromFormat('d/m/Y', $request->get('end_date'))->format('Y-m-d'),
            'search_for' => $request->get('search_for'),
            'type_printer' => $request->get('type_printer'),
            'month' => $request->get('month'),
            'year' => $request->get('year'),
            'print' => $request->get('print') == 'true' ? true : false,
            'sort_by' => $request->get('sort_by'),
            'sort_order' => !$request->get('sort_order') ? 'DESC' : ($request->get('sort_order') == 'false' ? 'ASC' : 'DESC')
        ];



        $filter = $this->service->mountFilter($queryParams);

        $results = $this->serviceCrud->scopeQuery($this->service->closureGetAll($filter), false, 0, !$queryParams['print'] ? ReserveContractListPresenter::class : ReserveContractPresenter::class);

        if (!$queryParams['sort_by'] || $queryParams['sort_by'] === 'code_reserve') {
            $dataSorted = $this->service->sortCodeReserve($results['data'], 'code_reserve', $queryParams['sort_order']);
        } else {
            $dataSorted = $this->service->sortBy($results['data'], $queryParams['sort_by'], $queryParams['sort_order']);
        }

        if ($queryParams['print']) {
            return $this->reserveContractPrinterService->generatePrinter($dataSorted, $queryParams['type_printer'], $filter);
        }

        return $dataSorted;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $closureHistoric = function ($query) use ($id) {
            return $query->where('reserve_id', $id)
                        ->orderBy('id', 'DESC');
        };


        return [
            'reserve' => $this->serviceCrud->find($id),
            'historic' => $this->reserveHistoricServiceCrud->scopeQuery($closureHistoric,false, 0, ReserveHistoricPresenter::class)['data'],
        ];
    }

    /**
     * Verifica se o contrato esta lançado em alguma reserva
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function checkContractIsRelease(Request $request)
    {
       $queryParams = [
           'contract' => $request->get('contract')
       ];

       $results = $this->serviceCrud->findWhere(['contract' => $queryParams['contract']]);
       if ($results->count()) {
           $message[] = "Contrato já lançado no sistema";
           return response($message, 422);
       }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function update($id)
    {
        $dataToUpdate = Request()->all();
        $rpLastAction = Auth::user()->id;
        $dataToUpdate['rp_last_action'] = $rpLastAction;

        $extraData = [];
        $financialData = [];

        /*
         * Verifico a existência dos dados financeiros
         */
        if (isset($dataToUpdate['financial_data'])) {
            $financialData = $dataToUpdate['financial_data'];
            unset($dataToUpdate['financial_data']);
        }

        /*
         * Remove campo código da reserva para nãa dar erro
         */
        unset($dataToUpdate['code_reserve']);

        $dataBeforeUpdate = $this->serviceCrud->find($id)->toArray();

        /*
         * Verifica se a reserva esta sendo cancelada para setar a data de conclusão e a data do fim do processo
         */
        if ($dataToUpdate['situation'] != $dataBeforeUpdate['situation'] && $dataToUpdate['situation'] == 'c') {
            $data['conclusion'] = date('Y-m-d');
            $data['end_process'] = date('Y-m-d');
        }

        /*
         * Verifica se a reserva esta sendo assinada para setar a data do fim do processo
         */
        if ($dataToUpdate['situation'] != $dataBeforeUpdate['situation'] && $dataToUpdate['situation'] == 'as') {
            $dataToUpdate['end_process'] = date('Y-m-d');
        }

        $dataChecked = $this->reserveContractCustomValidadeService->customValidade($dataToUpdate, $dataBeforeUpdate);
        if ($dataChecked) return $dataChecked;

        /*
       * Verifica se o usuário esta alterando a situação da reserva e colocando para assinado
       * para verificar se o numero de contrato não esta sendo usado
       */
        if($dataBeforeUpdate['situation'] != $dataToUpdate['situation'] and $dataToUpdate['situation'] == 'as'
            || $dataBeforeUpdate['situation'] != $dataToUpdate['situation'] and $dataToUpdate['situation'] == 'ap') {

            $closure = function ($query) use ($dataToUpdate) {
                return $query->where('situation', '!=', 'c')
                            ->where('contract', $dataToUpdate['contract']);
            };

            $check = $this->serviceCrud->scopeQuery($closure);
            if ($check->count()) {
                $message[] = "Contrato em uso";
                return response($message, 422);
            }
        }


        $dataAfterUpdate = $this->serviceCrud->update($dataToUpdate, $id);


        if (!isset($dataAfterUpdate->id)) {
            return $dataAfterUpdate;
        }

        if ($dataToUpdate['situation'] == 'c') {

            /*
            $reasonCancel = $this->reasonCancelServiceCrud->find($data['id_reason_cancel']);
            if ($data['reason_cancel_detail']) {
                $extraData['reason_cancel'] = uppercase($reasonCancel['reason']) . '. Detalhamento do motivo: '.$data['reason_cancel_detail'] ;
            } else {
                $extraData['reason_cancel'] = uppercase($reasonCancel['reason']);
            }
            */
        }

        $this->reserveHistoricService->updateReserve($dataBeforeUpdate, $dataAfterUpdate->toArray(), $extraData);

        /*
         * Verifica se o usuário informou algum histórico para gravação
         */
        if ($dataToUpdate['historic_data']['historic']) {

            $dataHistoric = [
                'historic' => $dataToUpdate['historic_data']['historic'],
                'reserve_id' => $dataAfterUpdate->id,
                'rp_last_action' => $rpLastAction
            ];


            $this->reserveHistoricServiceCrud->create($dataHistoric);
        }

        /*
         * Se possuir dados financeiros gravar na tabela contratos celebrados X tesouraria
         */
        if (isset($financialData['contract'])) {

            $dataReserve = $dataAfterUpdate->toArray();

            ///// gravar aqui contratos celebrados x tesouraria
            $financialData['reserve_id'] = $dataReserve['id'];
            $financialData['immobile_code'] = $dataReserve['immobile_code'];
            $financialData['address'] = $dataReserve['address'];
            $financialData['neighborhood'] = $dataReserve['neighborhood'];
            $financialData['rp_release'] = $dataReserve['attendant_register_id'];
            $financialData['conclusion'] = date('Y-m-d');

        }

        return [
            'data_reserve' => $dataAfterUpdate,
            'financial_data' => $financialData
        ];
    }

    /**
     * Retorna os anos disponiveis para mostrar no filtro se acompanhamento de reservas
     */
    public function getYearsAvailable()
    {
        return $this->service->getYearsAvailable();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function callPrinter(Request $request)
    {
        $queryParams = [
            'reserve_id' => $request->get('reserve_id'),
            'type_printer' => $request->get('type_printer')
        ];

        $viewName = '';

        $dataPrint = $this->serviceCrud->find($queryParams['reserve_id'], ReserveContractPresenter::class);

        if ($queryParams['type_printer'] === 'record_location') {
            $viewName = $dataPrint['data']['type_location'] == 'r' ? 'register::reserve.printer.RecordLocationResidential' : 'register::reserve.printer.RecordLocationCommercial';
        }


        return $this->printer($dataPrint['data'], $viewName);

    }
}
