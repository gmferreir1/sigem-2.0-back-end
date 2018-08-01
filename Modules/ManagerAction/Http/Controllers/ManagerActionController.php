<?php

namespace Modules\ManagerAction\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\ManagerAction\Presenters\ActionDatabasePresenter;
use Modules\ManagerAction\Services\ActionDatabaseServiceCrud;

class ManagerActionController extends Controller
{

    /**
     * @var ActionDatabaseServiceCrud
     */
    private $actionDatabaseServiceCrud;

    public function __construct(ActionDatabaseServiceCrud $actionDatabaseServiceCrud)
    {
        $this->actionDatabaseServiceCrud = $actionDatabaseServiceCrud;
    }

    /**
     * Retorna a listagem das ultimas tabelas atualizadas
     * @return mixed|null
     */
    public function showTablesUpdated()
    {
        // pega a data da ultima atualização na tabela
        $closure = function ($query) {
            return $query->orderBy('id', 'DESC');
        };
        $lastUpdate = $this->actionDatabaseServiceCrud->scopeQuery($closure);

        if (!$lastUpdate->count()) {
            return null;
        } else {
            $lastUpdate = $lastUpdate[0];
        }

        $date = date('Y-m-d', strtotime($lastUpdate->created_at));

        $closure = function ($query) use ($date) {
            return $query->whereBetween('created_at', ["$date 00:00:00", "$date 23:59:59"]);
        };

        return $this->actionDatabaseServiceCrud->scopeQuery($closure, false, 0, ActionDatabasePresenter::class)['data'];
    }


    /**
     * Dados de atualização das tabelas para serem mostrados no dashboard da administração do sistema
     */
    public function getTotalTablesUpdated()
    {
        $closure = function ($query) {
            return $query->orderBy('id', 'DESC');
        };

        $lastUpdate = $this->actionDatabaseServiceCrud->scopeQuery($closure);

        if ($lastUpdate->count()) {

            $lastUpdate = $lastUpdate[0];

            return date('Y-m-d H:i:s', strtotime($lastUpdate['created_at']));
        }

        return null;
    }
}
