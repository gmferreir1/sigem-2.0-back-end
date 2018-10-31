<?php

namespace Modules\Register\Services\ReserveContract;


use Carbon\Carbon;
use Modules\User\Services\UserServiceCrud;

class ReserveContractService
{
    /**
     * @var ReserveContractServiceCrud
     */
    private $serviceCrud;
    /**
     * @var UserServiceCrud
     */
    private $userServiceCrud;

    public function __construct(ReserveContractServiceCrud $serviceCrud, UserServiceCrud $userServiceCrud)
    {
        $this->serviceCrud = $serviceCrud;
        $this->userServiceCrud = $userServiceCrud;
    }


    public function checkFieldsToSave(array $data)
    {
        if ($data['situation'] != 'r') {

            return $this->message('Status selecionado não permitido');

        }
    }


    public function mountFilter($filter)
    {
        if (!$filter['situation']) {
            $filter['situation'] = array('r', 'p');
        }

        if (!$filter['responsible_register_sector']) {
            $filter['responsible_register_sector'] = collect($this->getIdsResponsible()['users_register_sector']);
        }

        if (!$filter['responsible_reception']) {
            $filter['responsible_reception'] = collect($this->getIdsResponsible()['users_reception']);
        }


        return $filter;
    }

    /**
     * Retorna os ids dos responsaveis para montagem do filtro
     * @return array
     */
    public function getIdsResponsible()
    {
        $responsibleRegisterSector = [];
        $responsibleReceptionSector = [];

        $allResults = $this->serviceCrud->all(false, 0, null, ['attendant_register_id', 'attendant_reception_id']);

        $responsibleRegisterSector = $allResults->unique('attendant_register_id')->pluck('attendant_register_id')->values()->all();
        $responsibleReceptionSector = $allResults->unique('attendant_reception_id')->pluck('attendant_reception_id')->values()->all();

        return [
            'users_register_sector' => $responsibleRegisterSector,
            'users_reception' => $responsibleReceptionSector
        ];
    }

    public function getYearsAvailable()
    {
        $allReserves = $this->serviceCrud->all(false,0, null, ['date_reserve']);

        $allDates = $allReserves->unique('date_reserve');
        $years = [];
        foreach ($allDates as $key => $date) {
            $years[$key] = ['year_reserve' => date('Y', strtotime($date['date_reserve']))];
        }

        $collection = collect($years)->unique('year_reserve')->sortBy('year_reserve')->values()->all();

        return $collection;
    }

    /**
     * Closure
     * @param $filter
     * @return \Closure
     */
    public function closureGetAll(array $filter)
    {

        if (!$filter['search_for'] || $filter['search_for'] == 'r') {

            $closure = function ($query) use ($filter) {
                return $query->whereIn('situation', $filter['situation'])
                    ->whereIn('attendant_register_id', $filter['responsible_register_sector'])
                    ->whereIn('attendant_reception_id', $filter['responsible_reception'])
                    ->whereBetween('date_reserve', array($filter['init_date'], $filter['end_date']));
            };
        }

        if ($filter['search_for'] == 'p') {

            $closure = function ($query) use ($filter) {
                return $query->whereIn('situation', $filter['situation'])
                    ->whereIn('attendant_register_id', $filter['responsible_register_sector'])
                    ->whereIn('attendant_reception_id', $filter['responsible_reception'])
                    ->whereBetween('prevision', array($filter['init_date'], $filter['end_date']));
            };
        }

        if ($filter['search_for'] == 'c') {

            $closure = function ($query) use ($filter) {
                return $query->whereIn('situation', $filter['situation'])
                    ->whereIn('attendant_register_id', $filter['responsible_register_sector'])
                    ->whereIn('attendant_reception_id', $filter['responsible_reception'])
                    ->whereBetween('conclusion', array($filter['init_date'], $filter['end_date']));
            };
        }

        return $closure;
    }

    /**
     * @param string $immobileCode
     * @return null
     */
    public function checkReserveIsRelease(string $immobileCode)
    {
        $endDate = date('Y-m-d');
        $initDate = Carbon::createFromFormat('Y-m-d', $endDate)->subDays(60)->format('Y-m-d');

        $closure = function ($query) use ($immobileCode, $initDate, $endDate) {
            return $query->where('immobile_code', $immobileCode)
                ->where('situation', 'r')
                ->orderBy('id', 'DESC')
                ->orWhere(function ($query) use ($initDate, $endDate, $immobileCode) {
                    $query->where('immobile_code', $immobileCode)
                        ->whereBetween('conclusion', array($initDate, $endDate))
                        ->whereNotIn('situation', array('r', 'c'))
                        ->orderBy('id', 'DESC');
                });
        };

        $check = $this->serviceCrud->scopeQuery($closure);

        return $check->count() ? $check[0] : null;
    }

    /**
     * Retorna todos os responsáveis
     * @return array
     */
    public function getAllResponsible() : array
    {
        $allResults = $this->serviceCrud->all(false, 0, null, ['attendant_register_id', 'attendant_reception_id']);

        $responsibleRegisterSector = $allResults->unique('attendant_register_id')->pluck('attendant_register_id')->values()->all();
        $responsibleReceptionSector = $allResults->unique('attendant_reception_id')->pluck('attendant_reception_id')->values()->all();



        $usersRegisterSector = [];
        foreach ($responsibleRegisterSector as $key => $item) {
            $userData = $this->userServiceCrud->find($item);

            $usersRegisterSector[$key] = [
                'id' => $item,
                'name' => "$userData->name $userData->last_name"
            ];
        }


        $usersReceptionSector = [];
        foreach ($responsibleReceptionSector as $key => $item) {
            $userData = $this->userServiceCrud->find($item);

            $usersReceptionSector[$key] = [
                'id' => $item,
                'name' => "$userData->name $userData->last_name"
            ];
        }


        return [
            'users_register_sector' => collect($usersRegisterSector)->sortBy('name')->values()->all(),
            'users_reception' => collect($usersReceptionSector)->sortBy('name')->values()->all()
        ];
    }

    public function sortCodeReserve(array $data, string $sortBy, $sortOrder)
    {
        if ($sortOrder == 'DESC') {
            array_multisort(array_column($data, 'year_r'), SORT_DESC, array_column($data, 'code_r'),      SORT_DESC, $data);
        }

        if ($sortOrder == 'ASC') {
            array_multisort(array_column($data, 'year_r'), SORT_ASC, array_column($data, 'code_r'),      SORT_ASC, $data);
        }

        return $data;
    }

    public function sortBy(array $data, string $sortBy, $sortOrder)
    {
        $collection = collect($data);

        if ($sortOrder == 'DESC') {
            return $collection->sortByDesc($sortBy)->values()->all();
        }

        if ($sortOrder == 'ASC') {
            return $collection->sortBy($sortBy)->values()->all();
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