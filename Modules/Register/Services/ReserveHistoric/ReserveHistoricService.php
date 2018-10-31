<?php

namespace Modules\Register\Services\ReserveHistoric;


use Illuminate\Support\Facades\Auth;
use Modules\User\Services\UserService;

class ReserveHistoricService
{

    /**
     * @var ReserveHistoricServiceCrud
     */
    private $serviceCrud;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(ReserveHistoricServiceCrud $serviceCrud, UserService $userService)
    {
        $this->serviceCrud = $serviceCrud;
        $this->userService = $userService;
    }


    /**
     * @param array $data
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function createReserve(array $data)
    {
        $dataToCreate = [
            'historic' => 'O usuario ' .  uppercase($this->userService->getNameById()) . ' abriu a reserva',
            'reserve_id' => $data['id'],
            'rp_last_action' => Auth::user()->id,
        ];

        return $this->serviceCrud->create($dataToCreate);
    }

    /**
     * @param array $beforeChange
     * @param array $afterChange
     * @param array $extraData
     * @return array
     * @throws \Exception
     */
    public function updateReserve(array $beforeChange, array $afterChange, array $extraData = [])
    {
        $message = [];
        $reserveId = $beforeChange['id'];
        $fullNameLogged = uppercase($this->userService->getNameById());

        /*
         * Alteração data da reserva
         */
        if ($beforeChange['date_reserve'] != $afterChange['date_reserve']) {
            $messageChange = "alterou a data da reserva de " . date('d/m/Y', strtotime($beforeChange['date_reserve'])) . " " . "para " . date('d/m/Y', strtotime($afterChange['date_reserve']));
            array_push($message, $messageChange);
        }

        /*
         * Alteração data da previsão
         */
        if ($beforeChange['prevision'] != $afterChange['prevision']) {
            $messageChange = "alterou a data da previsão de " . date('d/m/Y', strtotime($beforeChange['prevision'])) . " " . "para " . date('d/m/Y', strtotime($afterChange['prevision']));
            array_push($message, $messageChange);
        }

        /*
         * Alteração da situação
         */
        if ($beforeChange['situation'] != $afterChange['situation']) {

            if ($afterChange['situation'] == 'c') {

                if ($beforeChange['reason_cancel_detail']) {

                    $messageChange = "alterou a situação de " . getSituationNameReserve($beforeChange['situation']) . " para " . getSituationNameReserve($afterChange['situation']) .
                        " motivo: <span style='font-weight: bold; color:darkred'>" . $beforeChange['reason_cancel'] . "</span>
                                <p> Observação: ".$beforeChange['reason_cancel_detail']." </p>";

                } else {

                    $messageChange = "alterou a situação de " . getSituationNameReserve($beforeChange['situation']) . " para " . getSituationNameReserve($afterChange['situation']) .
                        " motivo: <span style='font-weight: bold; color:darkred'>" . $beforeChange['reason_cancel'] . "</span>";
                }

            } else {
                $messageChange = "alterou a situação de " .getSituationNameReserve($beforeChange['situation']) .
                    " para " .getSituationNameReserve($afterChange['situation']);
            }

            array_push($message, $messageChange);
        }

        /*
         * Alteração responsável cadastro
         */
        if ($beforeChange['attendant_register_id'] != $afterChange['attendant_register_id']) {
            $messageChange = "alterou o responsável do cadastro de " . uppercase($this->userService->getNameById($beforeChange['attendant_register_id'])) .
                " para " . uppercase($this->userService->getNameById($afterChange['attendant_register_id']));
            array_push($message, $messageChange);
        }

        /*
         * Alteração responsável recepção
         */
        if ($beforeChange['attendant_reception_id'] != $afterChange['attendant_reception_id']) {
            $messageChange = "alterou o responsável da recepção de " . uppercase($this->userService->getNameById($beforeChange['attendant_reception_id'])) .
                " para " . uppercase($this->userService->getNameById($afterChange['attendant_reception_id']));
            array_push($message, $messageChange);
        }

        /*
         * Alteração valor anunciado
         */
        if ($beforeChange['value'] != $afterChange['value']) {
            $messageChange = "alterou o valor anunciado de " . numberFormat($beforeChange['value']) .
                " para " . numberFormat($afterChange['value']);
            array_push($message, $messageChange);
        }

        /*
         * Alteração valor negociado
         */
        if ($beforeChange['value_negotiated'] != $afterChange['value_negotiated']) {
            $messageChange = "alterou o valor negociado de " . numberFormat($beforeChange['value_negotiated']) .
                " para " . numberFormat($afterChange['value_negotiated']);
            array_push($message, $messageChange);
        }

        foreach ($message as $msn) {

            $dataHistoric = [
                'historic' => "O usuário $fullNameLogged $msn",
                'rp_last_action' => Auth::user()->id,
                'reserve_id' => $reserveId
            ];

            $this->serviceCrud->create($dataHistoric);
        }

        return [
            'success' => true
        ];
    }
}