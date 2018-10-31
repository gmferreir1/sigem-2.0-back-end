<?php

namespace Modules\Register\Services\Transfer\Reason;


use Modules\Register\Services\Transfer\Contract\ContractServiceCrud;

class ReasonService
{
    /**
     * @var ContractServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ContractServiceCrud
     */
    private $contractServiceCrud;

    public function __construct(ReasonServiceCrud $serviceCrud, ContractServiceCrud $contractServiceCrud)
    {
        $this->serviceCrud = $serviceCrud;
        $this->contractServiceCrud = $contractServiceCrud;
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function checkExistsForUpdate(array $data)
    {
        $closure = function ($query) use ($data) {
            return $query->whereNotIn('id', array($data['id']))->where('reason', $data['reason']);
        };

        $results = $this->serviceCrud->scopeQuery($closure);

        if ($results->count()) {
            $message[] = "Motivo já registrado";
            return response($message, 422);
        }
    }

    /**
     * Verifica se o motivo esta em uso antes de remover
     * @param $reasonId
     * @return mixed
     */
    public function checkBeforeDelete($reasonId)
    {
        $closure = function ($query) use ($reasonId) {
            return $query->where('status', '!=', 'c')->where('reason_id', $reasonId);
        };

        $check = $this->contractServiceCrud->scopeQuery($closure);

        if ($check->count()) {
            $message[] = "Motivo em uso, não permitido remover";
            return response($message, 422);
        }
    }
}