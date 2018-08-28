<?php

namespace Modules\Register\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Register\Presenters\Transfer\ScoreAttendant\ScoreAttendantPresenter;
use Modules\Register\Services\Transfer\ScoreAttendant\ScoreAttendantService;
use Modules\Register\Services\Transfer\ScoreAttendant\ScoreAttendantServiceCrud;

class TransferScoreAttendantController extends Controller
{
    /**
     * @var ScoreAttendantServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ScoreAttendantService
     */
    private $service;

    public function __construct(ScoreAttendantServiceCrud $serviceCrud, ScoreAttendantService $service)
    {
        $this->serviceCrud = $serviceCrud;
        $this->service = $service;
    }


    public function all()
    {
        return $this->serviceCrud->all(false, 0, ScoreAttendantPresenter::class);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function save(Request $request)
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
        $checkToUpdate = $this->service->checkExistsForUpdate($dataToUpdate);
        if ($checkToUpdate) return $checkToUpdate;

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
