<?php

namespace Modules\Termination\Services;


use App\Traits\Generic\DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\User\Services\UserServiceCrud;

class ContractService
{

    /**
     * @var ContractServiceCrud
     */
    private $serviceCrud;
    /**
     * @var UserServiceCrud
     */
    private $userServiceCrud;

    use DateTime;

    public function __construct(ContractServiceCrud $serviceCrud, UserServiceCrud $userServiceCrud)
    {
        $this->serviceCrud = $serviceCrud;
        $this->userServiceCrud = $userServiceCrud;
    }

    /**
     * Limpas os campos que não serão utilizados
     * @param array $data
     * @return array
     */
    public function cleanFields(array $data) : array
    {
        // vistoria liberada
        if ($data['survey_release']) {
            $data['surveyor_id'] = null;
        }

        // se for inativação
        if ($data['type_register'] == 'termination') {
            $data['rp_register_sector'] = null;
            $data['new_contract_code'] = null;
        }

        // se não alugar novamente
        if ($data['rent_again'] == 'n') {
            $data['destination_id'] = null;
        }

        // se não possuir ressalvas
        if ($data['caveat'] == 'n') {
            $data['observation'] = null;
        }

        // se status for pendente remover a data do fim do processo
        if ($data['status'] == 'p' or $data['status'] == 'c') {
            $data['end_process'] = null;
        }

        return $data;
    }


    /**
     * Valida alguns campos condicionais
     * @param array $data
     * @return mixed
     */
    public function validadeFields(array $data)
    {
        // data da inativação
        if (!isset($data['termination_date']) || !$data['termination_date']) {
            return $this->message("Informe a data da inativação");
        }

        // dados do vistoriador
        if (!$data['survey_release'] && !$data['surveyor_id']) {
            return $this->message("Nenhum vistoriador definido");
        }

        // se for transferencia
        if ($data['type_register'] == 'transfer' && !$data['rp_register_sector'] && !$data['new_contract_code']) {
            return $this->message("Informe os dados da transferência");
        }

        // se alugar novamente
        if ($data['rent_again'] == 'y' && !$data['destination_id']) {
            return $this->message("Informe o destino");
        }

        // se possuir ressalvas
        if ($data['caveat'] == 'y' && !$data['observation']) {
            return $this->message( "Informe a ressalva");
        }
    }

    /**
     * Verifica se o status atual permite alterações
     * @param int $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function checkStatusAllowUpdate(int $id)
    {
        $queryInactivated = $this->serviceCrud->find($id);

        if ($queryInactivated->status != 'p') {
            return $this->message("O status atual não permite alterações");
        }
    }


    /**
     * Retorna os responsáveis pela inativação
     * @return array
     */
    public function getAllResponsible() : array
    {
        $allResults = $this->serviceCrud->all(false, 0, null, ['rp_per_inactive'])->unique('rp_per_inactive')->values()->all();
        $responsible = [];

        foreach ($allResults as $key => $item) {

            $userData = $this->userServiceCrud->find($item['rp_per_inactive']);

            $responsible[$key] = [
                'id' => $item['rp_per_inactive'],
                'name' => "$userData->name $userData->last_name"
            ];
        }

        return $this->sort($responsible, 'name');
    }


    /**
     * Montagem do filtro
     * @param array $filter
     * @return array
     */
    public function mountFilter(array $filter) : array
    {
        // data
        if (!isset($filter['init_date']) || !$filter['init_date'] || !isset($filter['end_date']) || !$filter['end_date']) {
            $filter['init_date'] = $this->init_date_system;
            $filter['end_date'] = $this->end_date_system;
        } else {
            $filter['init_date'] = Carbon::createFromFormat('d/m/Y', $filter['init_date'])->format('Y-m-d');
            $filter['end_date'] = Carbon::createFromFormat('d/m/Y', $filter['end_date'])->format('Y-m-d');
        }

        // status
        if (!isset($filter['status']) || !count($filter['status'])) {
            $filter['status'] = ['p'];
        }

        // responsável
        if (!isset($filter['responsible']) || !count($filter['responsible'])) {
            $filter['responsible'] = collect($this->getAllResponsible())->pluck('id');
        }

        return $filter;
    }


    /**
     * @param array $dataBeforeUpdate
     * @param array $dataAfterUpdate
     * @return array
     */
    public function checkChangesForMessageHistoric(array $dataBeforeUpdate, array $dataAfterUpdate)
    {
        $messages = [];

        // data da inativação
        $terminationDateBeforeUpdate = $dataBeforeUpdate['termination_date'];
        $terminationDateAfterUpdate = Carbon::createFromFormat('d/m/Y', $dataAfterUpdate['termination_date'])->format('Y-m-d');

        // data fim processo
        $endProcessBeforeUpdate = !$dataBeforeUpdate['end_process'] ? null : $dataBeforeUpdate['end_process'];
        $endProcessAfterUpdate = !$dataAfterUpdate['end_process'] ? null : Carbon::createFromFormat('d/m/Y', $dataAfterUpdate['end_process'])->format('Y-m-d');;

        // alteração da data inativação
        if (strtotime($terminationDateBeforeUpdate) != strtotime($terminationDateAfterUpdate)) {
            $message = "O usuario " . uppercase($this->getNameUserLogged()) . " alterou a data da inativacao de: " . formatDate($terminationDateBeforeUpdate) . " para "
            .formatDate($terminationDateAfterUpdate);

            array_push($messages, $message);
        }

        // alteração do responsável pela inativação
        if ($dataBeforeUpdate['rp_per_inactive'] != $dataAfterUpdate['rp_per_inactive']) {
            $message = "O usuario " . uppercase($this->getNameUserLogged()) . " alterou o responsavel pela inativacao de: " . uppercase($this->getNameUser($dataBeforeUpdate['rp_per_inactive'])) .
                        " para " . uppercase($this->getNameUser($dataAfterUpdate['rp_per_inactive']));
            array_push($messages, $message);
        }


        // verifica data da rescisão
        if (!$endProcessBeforeUpdate and $endProcessAfterUpdate) {
            $message = "O usuario " . uppercase($this->getNameUserLogged()) ."  definiu a data da rescisao para: " . formatDate($endProcessAfterUpdate);
            array_push($messages, $message);
        }

        // verifica data da rescisão
        if ($endProcessBeforeUpdate and $endProcessAfterUpdate and strtotime($endProcessBeforeUpdate) != strtotime($endProcessAfterUpdate)) {
            $message = "O usuario " . uppercase($this->getNameUserLogged()) ."  alterou a data da rescisao de: " . formatDate($endProcessBeforeUpdate) . " para: "
            .formatDate($endProcessAfterUpdate);
            array_push($messages, $message);
        }

        // verifica data da rescisão
        if ($endProcessBeforeUpdate and !$endProcessAfterUpdate) {
            $message = "O usuario " . uppercase($this->getNameUserLogged()) ." removeu a data da rescisao de: " . formatDate($endProcessBeforeUpdate);
            array_push($messages, $message);
        }


        // status
        if ($dataBeforeUpdate['status'] != $dataAfterUpdate['status']) {
            $message = "O usuario " . uppercase($this->getNameUserLogged()) ." alterou o status de: " . uppercase($this->getStatusName($dataBeforeUpdate['status'])) . " para: "
            . uppercase($this->getStatusName($dataAfterUpdate['status']));
            array_push($messages, $message);
        }

        return $messages;
    }


    /**
     * Retorna o ultimo e penultimo atendente
     * @return mixed
     */
    public function getLastAttendances()
    {
        $closure = function ($query) {
            return $query->select('rp_per_inactive')->orderBy('id', 'DESC')->limit(2);
        };

        $results = [];
        $data = $this->serviceCrud->scopeQuery($closure);

        if ($data->count()) {

            foreach ($data->toArray() as $key => $item) {
                $results[$key] = [
                    'name' => $this->getNameUser($item['rp_per_inactive'])
                ];
            }
        }

        return $results;
    }

    private function sort(array $data, string $sortBy)
    {
        $dataSorted = collect($data);

        if (!$dataSorted->count()) return [];

        return $dataSorted->sortBy($sortBy)->values()->all();
    }

    private function message(string $message)
    {
        $msn[] = $message;
        return response($msn, 422);
    }

    /**
     * Retorna o nome do usuário logado
     * @return string
     */
    private function getNameUserLogged() : string
    {
        $dataUserLogged = Auth::user();

        return "$dataUserLogged->name $dataUserLogged->last_name";
    }

    /**
     * Retorna o nome do usuário pelo id
     * @param int $id
     * @return string
     */
    public function getNameUser(int $id) : string
    {
        $user = $this->userServiceCrud->find($id);

        return "$user->name $user->last_name";
    }

    /**
     * Retorna o nome do status
     * @param string $status
     * @return string
     */
    private function getStatusName(string $status)
    {
        if ($status == 'p') {
            return "pendente";
        }

        if ($status == 'r') {
            return "resolvido";
        }

        if ($status == 'a') {
            return "acordo";
        }

        if ($status == 'j') {
            return "justica";
        }

        if ($status == 'cej') {
            return "cob.ext.jud";
        }

        if ($status == 'c') {
            return "cancelado";
        }
    }
}