<?php

namespace Modules\Register\Http\Controllers;

use App\Traits\Generic\DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Register\Services\ReserveContract\ReserveContractServiceCrud;

class ReserveContractController extends Controller
{

    use DateTime;

    /**
     * @var ReserveContractServiceCrud
     */
    private $serviceCrud;

    public function __construct(ReserveContractServiceCrud $serviceCrud)
    {
        $this->serviceCrud = $serviceCrud;
    }

    /**
     * Pega os dados do cliente pelo CPF
     * @param Request $request
     * @return array
     */
    public function getClient(Request $request)
    {
        $queryParams = [
            'client_cpf' => $request->get('client_cpf')
        ];

        $results = $this->serviceCrud->findWhere(['client_cpf' => $queryParams['client_cpf']]);

        if ($results->count()) {
            return [
                'client_name' => $results[0]['client_name'],
                'client_cpf' => $results[0]['client_cpf'],
                'client_rg' => $results[0]['client_rg'],
                'client_profession' => $results[0]['client_profession'],
                'client_company' => $results[0]['client_company'],
                'client_address' => $results[0]['client_address'],
                'client_neighborhood' => $results[0]['client_neighborhood'],
                'client_city' => $results[0]['client_city'],
                'client_state' => $results[0]['client_state'],
                'client_phone_01' => $results[0]['client_phone_01'],
                'client_phone_02' => $results[0]['client_phone_02'],
                'client_phone_03' => $results[0]['client_phone_03'],
                'client_email' => $results[0]['client_email'],
            ];
        }

        return [];
    }

    /**
     * @param Request $request
     * @return null
     */
    public function immobileIsRelease(Request $request)
    {
        $queryParams = [
            'immobile_code' => $request->get('immobile_code')
        ];

        $endDate = date('Y-m-d');
        $initDate = Carbon::createFromFormat('Y-m-d', $endDate)->subDays(60)->format('Y-m-d');


        $closure = function ($query) use ($queryParams, $initDate, $endDate) {
            return $query->where('immobile_code', $queryParams['immobile_code'])
                        ->where('situation', 'r')
                        ->orderBy('id', 'DESC')
                        ->orWhere(function ($query) use ($initDate, $endDate, $queryParams) {
                            $query->where('immobile_code', $queryParams['immobile_code'])
                                ->whereBetween('conclusion', array($initDate, $endDate))
                                ->whereNotIn('situation', array('r', 'c'))
                                ->orderBy('id', 'DESC');
                });
        };

        $check = $this->serviceCrud->scopeQuery($closure);

        return $check->count() ? $check[0] : null;
    }
}
