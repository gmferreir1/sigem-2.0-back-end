<?php

namespace Modules\Termination\Http\Controllers;

use App\Traits\Generic\Printer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Termination\Presenters\ImmobileReleasePresenter;
use Modules\Termination\Services\ImmobileReleaseService;
use Modules\Termination\Services\ImmobileReleaseServiceCrud;

class ImmobileReleaseController extends Controller
{
    use Printer;

    /**
     * @var ImmobileReleaseServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ImmobileReleaseService
     */
    private $service;

    public function __construct(ImmobileReleaseServiceCrud $serviceCrud, ImmobileReleaseService $service)
    {
        $this->serviceCrud = $serviceCrud;
        $this->service = $service;
    }


    public function all(Request $request)
    {
        $queryParams = [
            'status' => $request->get('status'),
            'responsible' => $request->get('responsible'),
            'init_date' => $request->get('init_date'),
            'end_date' => $request->get('end_date'),
            'printer' => $request->get('printer') === 'false' ? false : true,
        ];

        $filter = $this->service->mountFilter($queryParams);

        $closure = function ($query) use ($filter) {
            return $query->whereIn('status', $filter['status'])
                        ->whereIn('rp_receive', $filter['responsible'])
                        ->whereBetween('date_send', [$filter['init_date'], $filter['end_date']])
                        ->orderBy('date_send', 'ASC');
        };

        $results = $this->serviceCrud->scopeQuery($closure,false, 0, ImmobileReleasePresenter::class);

        if (!$queryParams['printer']) {
            return $results;
        }


        // for printer
        $results['period'] = !$queryParams['init_date'] || !$queryParams['end_date'] ? 'Geral' :  $queryParams['init_date'] . ' a ' . $queryParams['end_date'];

        return $this->printer($results, 'termination::printer.ListImmobileRelease');
    }

    public function find($id)
    {
        return $this->serviceCrud->find($id, ImmobileReleasePresenter::class)['data'];
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
     * @return array
     */
    public function getAllResponsible()
    {
        return $this->service->getAllResponsible();
    }
}
