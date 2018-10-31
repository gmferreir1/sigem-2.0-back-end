<?php

namespace Modules\ManagerAction\Services;


use App\Abstracts\Generic\Crud;
use Illuminate\Support\Facades\Auth;
use Modules\ManagerAction\Repositories\ActionDatabaseRepository;

class ActionDatabaseServiceCrud extends Crud
{

    /**
     * @var ActionDatabaseRepository
     */
    protected $repository;
    /**
     * @var null
     */
    protected $validator;

    private $idUpdated;

    public function __construct(ActionDatabaseRepository $repository, $validator = null)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Grava inicio do processo de atualização
     * @param string $tableName
     * @return mixed
     * @throws \Exception
     */
    public function initUpdateTable(string $tableName)
    {
        $actionDatabase = [
            'table_name' => $tableName,
            'rp_action' => Auth::user()->id,
            'status' => 'p'
        ];

        $result = parent::create($actionDatabase, false)->id;

        $this->idUpdated = $result;
    }

    /**
     * Grava o termino do processo de atualização
     * @param string $tableName
     * @throws \Exception
     */
    public function endUpdateTable(string $tableName)
    {
        $actionDatabase = [
            'status' => 'up', // updated
            'table_name' => $tableName
        ];

        parent::update($actionDatabase, $this->idUpdated, false);
    }
}