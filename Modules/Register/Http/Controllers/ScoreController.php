<?php

namespace Modules\Register\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Register\Presenters\ScoreAttendance\ScoreAttendancePresenter;
use Modules\Register\Services\ScoreAttendance\ScoreAttendanceService;
use Modules\Register\Services\ScoreAttendance\ScoreAttendanceServiceCrud;

class ScoreController extends Controller
{
    /**
     * @var ScoreAttendanceServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ScoreAttendanceService
     */
    private $service;

    public function __construct(ScoreAttendanceServiceCrud $serviceCrud, ScoreAttendanceService $service)
    {
        $this->serviceCrud = $serviceCrud;
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $closure = function ($query) {
            return $query->orderBy('score', 'ASC');
        };

        return $this->serviceCrud->scopeQuery($closure, false, 0, ScoreAttendancePresenter::class);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function save(Request $request)
    {
        $dataToSave = $request->all();
        $dataToSave['rp_last_action'] = Auth::user()->id;

        return $this->serviceCrud->create($dataToSave);
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

        $checkExistsToUpdate = $this->service->checkExistsForUpdate($dataToUpdate);

        if ($checkExistsToUpdate) {
            return $checkExistsToUpdate;
        }

        return $this->serviceCrud->update($dataToUpdate, $id);
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
