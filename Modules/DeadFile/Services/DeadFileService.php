<?php

namespace Modules\DeadFile\Services;

use Illuminate\Support\Facades\Auth;
use Modules\DeadFile\Presenters\DeadFilePresenter;
use Modules\Termination\Services\ContractServiceCrud;
use Modules\User\Services\UserServiceCrud;

class DeadFileService
{
    /**
     * @var DeadFileServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ContractServiceCrud
     */
    private $contractServiceCrud;
    /**
     * @var UserServiceCrud
     */
    private $userServiceCrud;

    public function __construct(DeadFileServiceCrud $serviceCrud, ContractServiceCrud $contractServiceCrud, UserServiceCrud $userServiceCrud)
    {
        $this->serviceCrud = $serviceCrud;
        $this->contractServiceCrud = $contractServiceCrud;
        $this->userServiceCrud = $userServiceCrud;
    }

    public function getYearsAvailable() : array
    {
        $allDeadFiles = $this->serviceCrud->all(false, 0, null, ['year_release']);

        $yearsAvailable = [];

        if ($allDeadFiles->count()) {

            foreach ($allDeadFiles->unique('year_release')->toArray() as $key => $item) {

                $yearsAvailable[$key] = [
                    'id' => $item['year_release'],
                    'name' => (string) $item['year_release']
                ];
            }

        } else {

            $yearsAvailable[0] = [
                'id' => date('Y'),
                'name' => date('Y')
            ];

            return $yearsAvailable;
        }

        return $this->sort($yearsAvailable, 'name');
    }

    public function archiveProcess(int $terminationId, string $contract)
    {
        /*
         * Verifica se o processo ja esta arquivado
         */
        $isArchived = $this->checkProcessIsArchived($terminationId, $contract);
        if ($isArchived) {
            $messages[] = 'Processo já arquivado no sistema';
            return response($messages, 422);
        }

        /*
         * Dados para arquivação do processo
         */
        $dataToArchive = $this->initArchiveProcess($terminationId);
        $dataToArchive['rp_last_action'] = Auth::user()->id;

        $resultArchive = $this->archive($dataToArchive);

        $userData = $this->userServiceCrud->find($resultArchive->rp_last_action);

        /*
         * Atualizo a tabela de contratos
         */
        $this->contractServiceCrud->update(['archive' => 1], $terminationId, false);

        return [
            'id' => $resultArchive->id,
            'cashier' => $resultArchive->cashier,
            'file' => $resultArchive->file,
            'date_archive' => date('Y-m-d H:i:s', strtotime($resultArchive['created_at'])),
            'rp_archive' => "$userData->name $userData->last_name"
        ];
    }

    /**
     * @param int $terminationId
     * @param string $contract
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function checkProcessIsArchived(int $terminationId = null, string $contract = null)
    {
        $closure = function ($query) use ($terminationId, $contract) {
            return $query->where('termination_id', $terminationId)
                ->where('status', 1)
                ->orWhere(function ($query) use ($contract) {
                    $query->where('contract', $contract)
                        ->where('status', 1);
                });
        };

        $results = $this->serviceCrud->scopeQuery($closure, false, 0, DeadFilePresenter::class);

        return count($results['data']) ? $results['data'][0] : null;
    }

    private function initArchiveProcess(int $terminationId)
    {
        $terminationData = $this->contractServiceCrud->find($terminationId);
        $typeArchive = $terminationData->status == 'j' ? 'justice' : 'rent';
        $yearCurrent = date('Y');

        /*
         * Verifico o ultimo lançamento feito
         */
        $closure = function ($query) use ($typeArchive) {
            return $query->where('type_release', $typeArchive)
                ->orderBy('id', 'DESC')
                ->limit(1);
        };

        $lastRelease = $this->serviceCrud->scopeQuery($closure);


        /*
         * Se não tiver lançamento retorna os valores iniciais do arquivo morto
         */
        if (!$lastRelease->count()) {

            $deadFileArchiveData = [
                'cashier' => 1,
                'file' => 1,
                'type_release' => $typeArchive,
                'status' => 1,
                'year_release' => $yearCurrent,
                'termination_date' => $terminationData->termination_date,
                'termination_id' => $terminationData->id,
                'contract' => $terminationData->contract,
            ];

            return $deadFileArchiveData;

        }

        /*
         * Verifico o ultimo lançamento do ano
         */
        $closure = function ($query) use ($typeArchive, $yearCurrent) {
            return $query->where('type_release', $typeArchive)
                ->where('year_release', $yearCurrent)
                ->orderBy('id', 'DESC')
                ->limit(1);
        };

        $lastReleaseYear = $this->serviceCrud->scopeQuery($closure);

        if ($lastReleaseYear->count()) {

            $deadFileArchiveData = [
                'cashier' => $lastRelease[0]['cashier'],
                'file' => $lastRelease[0]['file'] + 1
            ];

        } else {

            $deadFileArchiveData = [
                'cashier' => $lastRelease[0]['cashier'] + 1,
                'file' => 1
            ];
        }

        $deadFileArchiveData['type_release'] = $typeArchive;
        $deadFileArchiveData['status'] = 1;
        $deadFileArchiveData['year_release'] = $yearCurrent;
        $deadFileArchiveData['termination_date'] = $terminationData->termination_date;
        $deadFileArchiveData['termination_id'] = $terminationData->id;
        $deadFileArchiveData['contract'] = $terminationData->contract;


        return $deadFileArchiveData;
    }

    /**
     * @param array $archiveData
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    protected function archive(array $archiveData)
    {
        return $this->serviceCrud->create($archiveData);
    }

    private function sort(array $data, string $sortBy)
    {
        $collection = collect($data);
        return $collection->sortByDesc($sortBy)->values()->all();
    }
}