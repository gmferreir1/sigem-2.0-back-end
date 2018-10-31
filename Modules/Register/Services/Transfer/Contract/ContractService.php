<?php


namespace Modules\Register\Services\Transfer\Contract;


use Modules\Register\Presenters\Transfer\Contract\ContractPresenter;
use Modules\User\Services\UserService;

class ContractService
{
    /**
     * @var ContractServiceCrud
     */
    private $serviceCrud;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(ContractServiceCrud $serviceCrud, UserService $userService)
    {
        $this->serviceCrud = $serviceCrud;
        $this->userService = $userService;
    }

    /**
     * Verifica se o contracto esta lançado no sistema
     * @param string $contract
     * @return mixed
     */
    public function checkContractIsRelease(string $contract)
    {
        $closure = function ($query) use ($contract) {
            return $query->where('status', '!=', 'c')
                        ->where('contract', $contract);
        };

        $results = $this->serviceCrud->scopeQuery($closure);

        if ($results->count()) {
            $message = "Contrato lançado no sistema";
            return $this->message($message);
        }
    }

    /**
     * @param array $data
     * @param null $dataDatabase
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function customValidade(array $data, $dataDatabase = null)
    {
        if ($data['status'] != 'p' && !$dataDatabase) {
            $message = "Status não permitido na ação atual";
            return $this->message($message);
        }

        if ($data['status'] === 'c' && !$data['reason_cancel']) {
            $message = "Informe o motivo do cancelamento";
            return $this->message($message);
        }

        if ($data['status'] === 'c' && !isset($data['reason_cancel']) || $data['status'] === 'c' && !$data['reason_cancel']) {
            $message = "Informe o motivo do cancelamento";
            return $this->message($message);
        }

        if ($dataDatabase && $dataDatabase['status'] === 'r') {
            $message = "Status não permitido alteração";
            return $this->message($message);
        }
    }

    /**
     * @return array
     */
    public function getAllResponsible(): array
    {
        $responsible = [];
        $allTransferData = $this->serviceCrud->all(false, 0, ContractPresenter::class);
        $collectionUnique = collect($allTransferData['data'])->unique('responsible_transfer_id')->toArray();

        if (!count($collectionUnique)) {
            return [];
        }

        foreach ($collectionUnique as $key => $item) {

           // $responsibleName = $this->userService->getNameById($item['responsible_transfer_id']);

            $responsible[$key] = [
                'id' => $item['responsible_transfer_id'],
                'name' => $item['responsible_transfer_name']
            ];
        }

        return $this->sort($responsible, 'name');
    }

    /**
     * Retorna somente o array de ids para o filtro default
     * @return mixed
     */
    public function getAllResponsibleForFilter()
    {
        $allResponsible = $this->getAllResponsible();
        if (count($allResponsible)) {
            return collect($allResponsible)->pluck('id')->values()->all();
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

    /**
     * @param array $data
     * @param string $sortBy
     * @param string $sortOrder
     * @return mixed
     */
    public function sort(array $data, string $sortBy, string $sortOrder = null)
    {
        $results = collect($data);

        if ($sortOrder === 'desc') {
            return $results->sortByDesc($sortBy)->values()->all();
        }

        return $results->sortBy($sortBy)->values()->all();
    }
}