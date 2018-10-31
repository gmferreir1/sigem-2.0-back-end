<?php

namespace Modules\Register\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Register\Services\Transfer\Reason\ReasonService;
use Modules\Register\Services\Transfer\Reason\ReasonServiceCrud;

class TransferReasonController extends Controller
{

    /**
     * @var ReasonServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ReasonService
     */
    private $service;

    public function __construct(ReasonServiceCrud $serviceCrud, ReasonService $service)
    {
        $this->serviceCrud = $serviceCrud;
        $this->service = $service;
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

    public function all()
    {
        $closure = function ($query) {
            return $query->orderBy('reason', 'ASC');
        };

        return $this->serviceCrud->scopeQuery($closure);
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

        $checkBeforeUpdate = $this->service->checkExistsForUpdate($dataToUpdate);
        if ($checkBeforeUpdate) return $checkBeforeUpdate;

        return $this->serviceCrud->update($dataToUpdate, $id);
    }

    /**
     * @param $id
     * @return array|mixed
     */
    public function delete($id)
    {
        $checkExistsBeforeDelete = $this->service->checkBeforeDelete($id);
        if ($checkExistsBeforeDelete) return $checkExistsBeforeDelete;
        $this->serviceCrud->delete($id);

        return [
            'success' => true
        ];
    }
}
