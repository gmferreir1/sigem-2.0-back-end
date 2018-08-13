<?php

namespace Modules\DeadFile\Http\Controllers;

use App\Traits\Generic\Printer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\DeadFile\Presenters\DeadFilePresenter;
use Modules\DeadFile\Services\DeadFileService;
use Modules\DeadFile\Services\DeadFileServiceCrud;
use Modules\Termination\Services\ContractServiceCrud;

class DeadFileController extends Controller
{

    use Printer;

    /**
     * @var DeadFileServiceCrud
     */
    private $serviceCrud;
    /**
     * @var ContractServiceCrud
     */
    private $contractServiceCrud;
    /**
     * @var DeadFileService
     */
    private $deadFileService;

    public function __construct(DeadFileServiceCrud $serviceCrud, ContractServiceCrud $contractServiceCrud, DeadFileService $deadFileService)
    {
        $this->serviceCrud = $serviceCrud;
        $this->contractServiceCrud = $contractServiceCrud;
        $this->deadFileService = $deadFileService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function all(Request $request)
    {
        $queryParams = [
            'type_release' => !$request->get('type_release') ? array('rent') : $request->get('type_release'),
            'year_release' => !$request->get('year_release') ? array(date('Y')) : $request->get('year_release'),
            'printer' => $request->get('printer') == 'false' ? false : true
        ];

        $closure = function ($query) use ($queryParams) {
            return $query->whereIn('type_release', $queryParams['type_release'])
                        ->whereIn('year_release', $queryParams['year_release'])
                        ->orderBy('id', 'DESC');
        };

        $results = $this->serviceCrud->scopeQuery($closure, false, 0, DeadFilePresenter::class);

        if ($queryParams['printer']) {

            $results['filter_data'] = [
                'type_release' => count($queryParams['type_release']) == 1 ? ($queryParams['type_release'][0] == 'rent' ? 'Aluguel' : 'Justice') : 'Todos',
                'year_release' => count($queryParams['year_release']) == 1 ? $queryParams['year_release'][0] : 'Multiplos',
            ];


            return $this->printer($results, 'deadfile::printer.listDeadFile', 'landscape');
        }

        return $results;
    }

    public function getYearsAvailable ()
    {
        return $this->deadFileService->getYearsAvailable();
    }

    /**
     * Cancela o arquivamento do processo
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function cancelArchive($id)
    {
        // verifica o status do arquivamento
        $check = $this->serviceCrud->find($id);
        if ($check->status == 2) {
            $message[] = "Arquivamento já cancelado no sistema";
            return response($message, 422);
        }

        $dataToUpdate = [
            'status' => 2,
            'rp_last_action' => Auth::user()->id
        ];

        $dataUpdated = $this->serviceCrud->update($dataToUpdate, $id, false);

        if (!isset($dataUpdated->id)) {
            return $dataUpdated;
        }

        // desarquivar a inativação caso ela exista
        if ($dataUpdated->termination_id) {
            $dataToUpdateTermination = [
                'archive' => 0
            ];

            $this->contractServiceCrud->update($dataToUpdateTermination, $dataUpdated->termination_id, false);
        }

        return $dataUpdated;
    }
}
