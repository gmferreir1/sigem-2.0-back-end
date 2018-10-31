<?php

namespace Modules\Termination\Services;

use App\Abstracts\Generic\Crud;
use Illuminate\Support\Facades\Auth;
use Modules\Termination\Repositories\HistoricRepository;

class HistoricServiceCrud extends Crud
{
    /**
     * @var HistoricRepository
     */
    protected $repository;

    protected $validator;

    public function __construct(HistoricRepository $repository, $validator = null)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }


    /**
     * @param string $message
     * @param int $contractId
     * @param string|null $typeAction
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function createHistoric(string $message, int $contractId, string $typeAction = null)
    {
        $dataUser = Auth::user();

        $fullName = uppercase($dataUser->name) . ' ' . uppercase($dataUser->last_name);

        $dataToCreate = [
            'contract_id' => $contractId,
            'historic' => "O usuário $fullName $message",
            'type_action' => $typeAction,
            'rp_last_action' => $dataUser->id
        ];

        return parent::create($dataToCreate, false);
    }
}