<?php

namespace Modules\Termination\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Termination\Services\DestinationOrReasonService;
use Modules\Termination\Services\DestinationOrReasonServiceCrud;

class DestinationOrReasonController extends Controller
{

    /**
     * @var DestinationOrReasonService
     */
    protected $service;
    /**
     * @var DestinationOrReasonServiceCrud
     */
    protected $serviceCrud;

    public function __construct(DestinationOrReasonService $service, DestinationOrReasonServiceCrud $serviceCrud)
    {
        $this->service = $service;
        $this->serviceCrud = $serviceCrud;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $dataToCreate = $request->all();
        $dataToCreate['rp_last_action'] = Auth::user()->id;

        $checkExists = $this->service->checkExists($dataToCreate['type'], $dataToCreate['text']);

        if ($checkExists) {
            return $checkExists;
        };

        return $this->serviceCrud->create($dataToCreate);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $dataToUpdate = $request->all();
        $dataToUpdate['rp_last_action'] = Auth::user()->id;

        $checkExists = $this->service->checkExistsToUpdate($dataToUpdate['type'], $dataToUpdate['text'], $id);

        if ($checkExists) {
            return $checkExists;
        };

        return $this->serviceCrud->update($dataToUpdate, $id);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $closure = function ($query) {
            return $query->orderBy('text', 'ASC');
        };

        return $this->serviceCrud->scopeQuery($closure);
    }
}
