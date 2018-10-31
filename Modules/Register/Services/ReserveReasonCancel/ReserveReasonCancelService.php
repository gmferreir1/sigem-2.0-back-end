<?php

namespace Modules\Register\Services\ReserveReasonCancel;


use Modules\Register\Services\ReserveContract\ReserveContractServiceCrud;

class ReserveReasonCancelService
{
    /**
     * @var ReserveReasonCancelServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ReserveContractServiceCrud
     */
    private $reserveContractServiceCrud;

    public function __construct(ReserveReasonCancelServiceCrud $serviceCrud, ReserveContractServiceCrud $reserveContractServiceCrud)
    {
        $this->serviceCrud = $serviceCrud;
        $this->reserveContractServiceCrud = $reserveContractServiceCrud;
    }

    /**
     * Verifica se o motivo esta cadastrado
     * @param array $data
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function checkExistsForUpdate(array $data)
    {
        $closure = function ($query) use ($data) {
            return $query->whereNotIn('id', array($data['id']))
                ->where('reason', $data['reason']);
        };

        $results = $this->serviceCrud->scopeQuery($closure);

        if ($results->count()) {
            return $this->message("Motivo já registrado");
        }
    }

    /**
     * @param int $reasonId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function checkReasonInUsed(int $reasonId)
    {
        $check = $this->reserveContractServiceCrud->findWhere(['id_reason_cancel' => $reasonId]);

        if ($check->count()) {
            return $this->message("Motivo em uso, não pode ser removido");
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