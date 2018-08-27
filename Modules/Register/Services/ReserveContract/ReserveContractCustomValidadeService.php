<?php

namespace Modules\Register\Services\ReserveContract;


class ReserveContractCustomValidadeService
{

    /**
     * @param array $dataInBd
     * @param array $dataPost
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function customValidade(array $dataPost, array $dataInBd = null)
    {

        /*
         * Verifica se na criação o primeiro status é reserva
         */
        if (!isset($dataPost['id']) and $dataPost['situation'] != 'r') {
            return $this->message('Status informado não permitido nesta operação');
        }

        if ($dataInBd)  {

           /*
            * Verifica se ha alteração de situação
            */
            if ($dataInBd['situation'] != $dataPost['situation']) {

                /*
                 * Verifica se o usuário esta definindo o status para cancelado
                 * para setar a data de conclusão
                 */
                if ($dataPost['situation'] == 'c') {

                    if (!isset($dataPost['id_reason_cancel']) || !$dataPost['id_reason_cancel']) {
                        return $this->message('Informe o motivo do cancelamento !');
                    }


                    if (!isset($dataPost['conclusion']) || !$dataPost['conclusion']) {
                        return $this->message('Informe a data de cancelamento !');
                    }

                }
            }

            /*
             * Verifica se o usuário esta alterando a situação da reserva e colocando para assinado
             * para exigir o numero de contrato
             */
            if($dataInBd['situation'] != $dataPost['situation'] and $dataPost['situation'] == 'as' || $dataInBd['situation'] != $dataPost['situation'] and $dataPost['situation'] == 'ap') {
                // verifica se foi passado o contrato
                if (!$dataPost['contract']) {
                    return $this->message('Informe o número do contrato para continuar');
                }
            }


            /*
             * Verifica se o usuário esta alterando a situação da reserva e colocando para assinado com pendencia
             * para exigir o numero de contrato
             */
            if($dataInBd['situation'] != $dataPost['situation'] and $dataPost['situation'] == 'ap' and !$dataPost['contract']) {
                return $this->message('Informe o número do contrato para continuar');
            }

        }

    }

    /**
     * @param string $message
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    private function message(string $message)
    {
        $msn[] = $message;
        return response($msn, 422);
    }

}