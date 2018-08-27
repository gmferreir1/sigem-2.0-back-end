<?php

namespace Modules\Financial\Http\Controllers;

use App\Helpers\Mailer;
use App\Traits\Generic\DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Financial\Services\ContractCelebrated\ContractCelebratedServiceCrud;
use Modules\Sicadi\Services\QueryService;

class ContractCelebratedController extends Controller
{
    use DateTime;

    /**
     * @var ContractCelebratedServiceCrud
     */
    private $serviceCrud;
    /**
     * @var QueryService
     */
    private $queryService;
    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(ContractCelebratedServiceCrud $serviceCrud, QueryService $queryService, Mailer $mailer)
    {
        $this->serviceCrud = $serviceCrud;
        $this->queryService = $queryService;
        $this->mailer = $mailer;
    }

    public function all(Request $request)
    {
        $queryParams = [
            'init_date' => !$request->get('init_date') ? $this->init_date_system : Carbon::createFromFormat('d/m/Y', $request->get('init_date'))->format('Y-m-d'),
            'end_date' => !$request->get('end_date') ? $this->end_date_system : Carbon::createFromFormat('d/m/Y', $request->get('end_date'))->format('Y-m-d'),
            'status' => !$request->get('status') ? array('p') : $request->get('status')
        ];

        $closure = function ($query) use ($queryParams) {
            return $query->whereIn('status', $queryParams['status'])
                        ->whereBetween('delivery_key', array($queryParams['init_date'], $queryParams['end_date']))
                        ->orderBy('delivery_key', 'DESC');
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

        // pega os dados do imovel
        $immobileData = $this->queryService->getImmobileData($dataToSave['immobile_code']);

        if ($immobileData) {

            $dataToSave['address'] = $immobileData['address'];
            $dataToSave['neighborhood'] = $immobileData['neighborhood'];
            $dataToSave['owner_name'] = $immobileData['owner'];
            $dataToSave['subscription_iptu'] = $immobileData['iptu'];
            $dataToSave['rp_last_action'] = Auth::user()->id;

            $dataSaved = $this->serviceCrud->create($dataToSave);

            if (isset($dataSaved->id)) {
                $emailTo = env('EMAIL_TESOURARIA');
                $nameTo = "Financeiro Master Imóveis";
                $subject = "Novo contrato celebrado nº " . uppercase($dataSaved->contract);

                $dataBodyMail = [
                    'data' => [
                        'text_mail' => '<tr>
                                        <td class="content-block">
                                            Existe um novo contrato nº <strong>' .uppercase($dataSaved->contract). '</strong> na bancada de celebrados.
                                        </td>
                                    </tr>'
                    ],
                    'view' => 'email.internalNotification'
                ];

                $this->mailer->config($emailTo, $nameTo, $subject, $dataBodyMail)->send();
            }

        }

    }
}
