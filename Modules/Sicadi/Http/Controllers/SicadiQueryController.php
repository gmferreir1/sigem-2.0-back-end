<?php

namespace Modules\Sicadi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sicadi\Services\QueryService;

class SicadiQueryController extends Controller
{

    /**
     * @var QueryService
     */
    private $service;

    public function __construct(QueryService $service)
    {
        $this->service = $service;
    }

    /**
     * Retorna dados do imovel pelo contrato
     * @param Request $request
     * @return array|mixed
     */
    public function queryImmobileData(Request $request)
    {
        $queryParams = [
            'query_by' => $request->get('query_by'),
            'value_query' => $request->get('value_query')
        ];

        if ($queryParams['query_by'] == 'contract') {
            return $this->service->getImmobileDataPerContract($queryParams['value_query'], false);
        }

        return [];
    }
}
