<?php

namespace Modules\Termination\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Termination\Services\ContractService;
use Modules\Termination\Services\RentAccessoryServiceCrud;

class RentAccessoryController extends Controller
{
    /**
     * @var ContractService
     */
    private $contractService;
    /**
     * @var RentAccessoryServiceCrud
     */
    private $serviceCrud;

    public function __construct(ContractService $contractService, RentAccessoryServiceCrud $serviceCrud)
    {
        $this->contractService = $contractService;
        $this->serviceCrud = $serviceCrud;
    }

    /**
     * Busca dados do acessorios da locação pelo codigo da inativação
     * @param $terminationId
     * @return mixed
     */
    public function find($terminationId)
    {
        $results = $this->serviceCrud->findWhere(['termination_id' => $terminationId]);

        return count($results) ? $results[0] : null;
    }

    /**
     * Atualização dos dados
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $dataToUpdate = $request->all();
        $dataToUpdate['rp_last_action'] = Auth::user()->id;

        $rentAccessoryData = $this->serviceCrud->find($id);

        // verifica o status da inativação se é permitido alteração
        $checkStatusInactivation = $this->contractService->checkStatusAllowUpdate($rentAccessoryData->termination_id);
        if ($checkStatusInactivation) return $checkStatusInactivation;

        return $this->serviceCrud->update($dataToUpdate, $id, false);
    }
}
