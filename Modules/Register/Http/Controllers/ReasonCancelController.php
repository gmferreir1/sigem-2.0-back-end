<?php

namespace Modules\Register\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Register\Services\ReserveReasonCancel\ReserveReasonCancelService;
use Modules\Register\Services\ReserveReasonCancel\ReserveReasonCancelServiceCrud;

class ReasonCancelController extends Controller
{
    /**
     * @var ReserveReasonCancelServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ReserveReasonCancelService
     */
    private $service;

    public function __construct(ReserveReasonCancelServiceCrud $serviceCrud, ReserveReasonCancelService $service)
    {
        $this->serviceCrud = $serviceCrud;
        $this->service = $service;
    }

    public function all()
    {
        $closure = function ($query) {
            return $query->orderBy('reason', 'ASC');
        };

        return $this->serviceCrud->scopeQuery($closure);
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

        $check = $this->service->checkExistsForUpdate($dataToUpdate);

        if ($check) {
            return $check;
        }

        return $this->serviceCrud->update($dataToUpdate, $id);
    }

    /**
     * @param $id
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function delete($id)
    {
        $checkInUsed = $this->service->checkReasonInUsed($id);

        if ($checkInUsed) {
            return $checkInUsed;
        }

        $this->serviceCrud->delete($id);

        return [
            'success' => true
        ];
    }
}
