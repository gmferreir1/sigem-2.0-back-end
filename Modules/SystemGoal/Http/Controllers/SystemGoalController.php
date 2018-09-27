<?php

namespace Modules\SystemGoal\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\SystemGoal\Presenters\SystemGoalPresenter;
use Modules\SystemGoal\Services\SystemGoalServiceCrud;

class SystemGoalController extends Controller
{
    /**
     * @var SystemGoalServiceCrud
     */
    private $serviceCrud;

    public function __construct(SystemGoalServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function save(Request $request)
    {
        $dataSave = $request->all();
        $dataSave['rp_last_action'] = Auth::user()->id;

        // verifica se existe o cadastro da meta
        $check = $this->serviceCrud->findWhere(['name' => $dataSave['name'], 'type' => $dataSave['type']]);

        if ($check->count()) {
            $message[] = "Meta já registrada no sistema";
            return response($message, 422);
        }

        return $this->serviceCrud->create($dataSave);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $dataUpdate = $request->all();
        $dataUpdate['rp_last_action'] = Auth::user()->id;

        $closure = function ($query) use ($dataUpdate, $id) {
            return $query->whereNotIn('id', array($id))
                        ->where('name', $dataUpdate['name'])
                        ->where('type', $dataUpdate['type']);
        };

        // verifica se existe o cadastro da meta
        $check = $this->serviceCrud->scopeQuery($closure);

        if ($check->count()) {
            $message[] = "Meta já registrada no sistema";
            return response($message, 422);
        }

        return $this->serviceCrud->update($dataUpdate, $id);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $closure = function ($query) {
            return $query->orderBy('name', 'ASC');
        };

        return $this->serviceCrud->scopeQuery($closure,false, 0, SystemGoalPresenter::class)['data'];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->serviceCrud->find($id);
    }

    /**
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $this->serviceCrud->delete($id);

        return [
            'success' => true
        ];
    }
}
