<?php

namespace Modules\Termination\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Termination\Presenters\ScorePresenter;
use Modules\Termination\Services\ScoreServiceCrud;

class ScoreController extends Controller
{
    /**
     * @var ScoreServiceCrud
     */
    private $serviceCrud;

    public function __construct(ScoreServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    /***
     * @return mixed
     */
    public function all()
    {
        $closure = function ($query) {
            return $query->orderBy('score', 'ASC');
        };

        return $this->serviceCrud->scopeQuery($closure,false, 0, ScorePresenter::class);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $dataToCreate = $request->all();
        $dataToCreate['rp_last_action'] = Auth::user()->id;

        return $this->serviceCrud->create($dataToCreate);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $dataToUpdate = $request->all();
        $dataToUpdate['rp_last_action'] = Auth::user()->id;

        return $this->serviceCrud->update($dataToUpdate, $id);
    }

    /**
     * Remove the specified resource from storage.
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

    /**
     * Retorna o proximo atendente
     * @return array
     */
    public function getNextAttendance()
    {
        $closure = function ($query) {
            return $query->orderBy('score', 'ASC');
        };

        $results = $this->serviceCrud->scopeQuery($closure);

        if ($results->count()) {
            return [
                'attendant_id' => $results[0]['attendant_id']
            ];
        }
    }
}
