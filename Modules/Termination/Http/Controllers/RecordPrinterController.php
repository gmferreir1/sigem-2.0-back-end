<?php

namespace Modules\Termination\Http\Controllers;

use App\Traits\Generic\Printer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Termination\Services\ContractServiceCrud;
use Modules\Termination\Services\DestinationOrReasonService;
use Modules\Termination\Services\RecordPrinterService;
use Modules\Termination\Services\RentAccessoryServiceCrud;
use Modules\User\Services\UserService;

class RecordPrinterController extends Controller
{

    use Printer;

    /**
     * @var ContractServiceCrud
     */
    private $contractServiceCrud;
    /**
     * @var RentAccessoryServiceCrud
     */
    private $rentAccessoryServiceCrud;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var DestinationOrReasonService
     */
    private $destinationOrReasonService;
    /**
     * @var RecordPrinterService
     */
    private $service;

    public function __construct(ContractServiceCrud $contractServiceCrud, RentAccessoryServiceCrud $rentAccessoryServiceCrud, UserService $userService
                                , DestinationOrReasonService $destinationOrReasonService, RecordPrinterService $service)
    {
        $this->contractServiceCrud = $contractServiceCrud;
        $this->rentAccessoryServiceCrud = $rentAccessoryServiceCrud;
        $this->userService = $userService;
        $this->destinationOrReasonService = $destinationOrReasonService;
        $this->service = $service;
    }

    public function printerRecord(Request $request)
    {
        $queryParams = [
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'termination_id' => $request->get('termination_id'),
            'survey_date' => $request->get('survey_date'),
            'name_rp_delivery_key' => $request->get('name_rp_delivery_key'),
            'cpf_rp_delivery_key' => $request->get('cpf_rp_delivery_key')
        ];

        $dataPrint = [];

        $dataPrint['termination'] = $this->contractServiceCrud->find($queryParams['termination_id'])->toArray();
        $dataPrint['termination']['rp_per_inactive_name'] = $this->userService->getNameById($dataPrint['termination']['rp_per_inactive']);
        $dataPrint['termination']['rp_register_sector_name'] = $dataPrint['termination']['rp_register_sector'] ? $this->userService->getNameById($dataPrint['termination']['rp_register_sector']) : null;
        $dataPrint['termination']['reason_name'] = $this->destinationOrReasonService->getDestinationOrReasonNameById($dataPrint['termination']['reason_id']);
        $dataPrint['termination']['destination_name'] = $this->destinationOrReasonService->getDestinationOrReasonNameById($dataPrint['termination']['destination_id']);
        $dataPrint['rental_accessory'] = $this->rentAccessoryServiceCrud->findWhere(['termination_id' => $queryParams['termination_id']])[0];

        // ficha de rescisão
        if ($queryParams['name'] == 'termination' && $queryParams['type'] == 'pdf') {
            return $this->printer($dataPrint, 'termination::printer.recordTermination');
        }

        // ficha de transferência
        if ($queryParams['name'] == 'transfer' && $queryParams['type'] == 'pdf') {
            return $this->printer($dataPrint, 'termination::printer.recordTransfer');
        }

        // entrega de chaves com pendencia
        if ($queryParams['name'] == 'delivery_keys_pendencie') {

            $dataPrint['survey_date'] = $queryParams['survey_date'];

            if (!$dataPrint['survey_date']) {
                $message[] = "Data da vistoria não informada";
                return response($message, 422);
            }

            if ($queryParams['type'] == 'pdf') {
                return $this->printer($dataPrint, 'termination::printer.recordDeliveryKeyPendencies');
            }

            if ($queryParams['type'] == 'word') {
                return $this->service->deliveryKeyPendencieDoc($dataPrint);
            }

        }

        // entrega de chaves antes da vistoria
        if ($queryParams['name'] == 'delivery_keys_before_survey') {
            $dataPrint['client_data']['name'] = $queryParams['name_rp_delivery_key'];
            $dataPrint['client_data']['cpf'] = $queryParams['cpf_rp_delivery_key'];

            if ($queryParams['type'] == 'pdf') {
                return $this->printer($dataPrint, 'termination::printer.recordDeliveryKeyBeforeSurvey');
            }

            if ($queryParams['type'] == 'word') {
                return $this->service->deliveryKeyBeforeSurvey($dataPrint);
            }
        }

        // entrega de chaves apos a vistoria
        if ($queryParams['name'] == 'delivery_keys_after_survey') {
            $dataPrint['client_data']['name'] = $queryParams['name_rp_delivery_key'];
            $dataPrint['client_data']['cpf'] = $queryParams['cpf_rp_delivery_key'];

            if ($queryParams['type'] == 'pdf') {
                return $this->printer($dataPrint, 'termination::printer.recordDeliveryKeyAfterSurvey');
            }

            if ($queryParams['type'] == 'word') {
                return $this->service->deliveryKeyAfterSurvey($dataPrint);
            }
        }

    }
}
