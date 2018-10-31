<?php

namespace Modules\Register\Services\Transfer\Historic;


use Illuminate\Support\Facades\Auth;
use Modules\User\Services\UserService;

class HistoricService
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var HistoricServiceCrud
     */
    private $serviceCrud;

    public function __construct(UserService $userService, HistoricServiceCrud $serviceCrud)
    {
        $this->userService = $userService;
        $this->serviceCrud = $serviceCrud;
    }

    /**
     * @param int $transferId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function actionCreate(int $transferId)
    {
        $message = "O usuario " . uppercase($this->userService->getNameById()) . " abriu a transferência";

        $this->createActionHistoric($message, $transferId);
    }

    /**
     * @param array $dataToUpdate
     * @param array $dataInDb
     * @param int $transferId
     * @throws \Exception
     */
    public function actionUpdate(array $dataToUpdate, array $dataInDb, int $transferId)
    {
        $messages = [];

        if ($dataToUpdate['status'] != $dataInDb['status']) {
            $message = "O usuario " . uppercase($this->userService->getNameById()) . " alterou o status da transferencia de " . $this->getStatusName($dataToUpdate['status']) . " para "
            . $this->getStatusName($dataInDb['status']);

            array_push($messages, $message);
        }


        if ($dataToUpdate['status'] === 'c') {
            $message = "O usuario " . uppercase($this->userService->getNameById()) . " alterou o status da transferencia de " . $this->getStatusName($dataToUpdate['status']) . " para "
                . $this->getStatusName($dataInDb['status']) . ". Motivo: " . $dataToUpdate['reason_cancel'];

            array_push($messages, $message);
        }

        if ($dataToUpdate['responsible_transfer_id'] != $dataInDb['responsible_transfer_id']) {
            $message = "O usuario " . uppercase($this->userService->getNameById()) . " alterou o responsavel pela transferencia de " . uppercase($this->userService->getNameById($dataInDb['responsible_transfer_id'])) .
                        " para " . uppercase($this->userService->getNameById($dataToUpdate['responsible_transfer_id']));

            array_push($messages, $message);
        }

        if ($dataToUpdate['status'] === 'r') {
            $message = "O usuario " . uppercase($this->userService->getNameById()) . " finalizou a transferencia com o novo numero de contrato: " . uppercase($dataToUpdate['new_contract']);

            array_push($messages, $message);
        }


        if (count($messages)) {
            foreach ($messages as $msn) {
                $this->createActionHistoric($msn, $transferId);
            }
        }

    }

    private function getStatusName(string $status)
    {
        if ($status == 'p') {
            return 'pendente';
        }

        if ($status == 'r') {
            return 'resolvido';
        }

        if ($status == 'c') {
            return 'cancelado';
        }
    }

    /**
     * @param string $historic
     * @param int $transferId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    private function createActionHistoric(string $historic, int $transferId)
    {
        $dataToSave = [
            'historic' => $historic,
            'rp_last_action' => Auth::user()->id,
            'transfer_id' => $transferId
        ];

        return $this->serviceCrud->create($dataToSave);
    }
}