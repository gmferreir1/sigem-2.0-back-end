<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Traits\Generic\DateTime;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Register\Services\ReserveContract\ReserveContractServiceCrud;
use Modules\SystemGoal\Services\SystemGoalServiceCrud;
use Modules\Termination\Services\ContractServiceCrud;

class DataGraphController extends Controller
{
    use DateTime;

    /**
     * @var SystemGoalServiceCrud
     */
    private $systemGoalServiceCrud;
    /**
     * @var ReserveContractServiceCrud
     */
    private $reserveContractServiceCrud;
    /**
     * @var ContractServiceCrud
     */
    private $terminationContractServiceCrud;

    public function __construct(ReserveContractServiceCrud $reserveContractServiceCrud, SystemGoalServiceCrud $systemGoalServiceCrud, ContractServiceCrud $terminationContractServiceCrud)
    {
        $this->systemGoalServiceCrud = $systemGoalServiceCrud;
        $this->reserveContractServiceCrud = $reserveContractServiceCrud;
        $this->terminationContractServiceCrud = $terminationContractServiceCrud;
    }

    /**
     * Acompanhamento por status de contratos celebrados
     * @return array
     */
    public function dataGraphContractCelebratedPerStatus()
    {
        $month = date('m');
        $year = date('Y');

        $closureReserve = function ($query) use ($year, $month) {
            return $query->whereBetween('date_reserve', [$this->initDateCurrentMonth($year, $month), $this->endDateCurrentMonth($year, $month)]);
        };


        $closureAssigned = function ($query) use ($year, $month) {
            return $query->whereBetween('conclusion', [$this->initDateCurrentMonth($year, $month), $this->endDateCurrentMonth($year, $month)]);
        };

        $closureReserveCanceledMonth =  function ($query) use ($year, $month) {
            return $query->where('situation', 'c')
                ->whereBetween('date_reserve', [$this->initDateCurrentMonth($year, $month), $this->endDateCurrentMonth($year, $month)]);
        };

        $closureCanceledMonth =  function ($query) use ($year, $month) {
            return $query->where('situation', 'c')
                ->whereNotBetween('date_reserve', [$this->initDateCurrentMonth($year, $month), $this->endDateCurrentMonth($year, $month)])
                ->whereBetween('conclusion', [$this->initDateCurrentMonth($year, $month), $this->endDateCurrentMonth($year, $month)]);
        };


        $dataReserve = $this->reserveContractServiceCrud->scopeQuery($closureReserve);
        $dataAssigned = $this->reserveContractServiceCrud->scopeQuery($closureAssigned);
        $dataReserveCanceledMonth = $this->reserveContractServiceCrud->scopeQuery($closureReserveCanceledMonth);
        $dataCanceledMonth = $this->reserveContractServiceCrud->scopeQuery($closureCanceledMonth);


        return [
            'data' => [

                [
                    'name' => 'Reserva',
                    'y' => $dataReserve->where('situation', 'r')->count(),
                    'color' => '#000000'
                ],
                [
                    'name' => 'Documentação',
                    'y' => $dataReserve->where('situation', 'd')->count(),
                    'color' => '#1B6AAA'
                ],
                [
                    'name' => 'Análise',
                    'y' => $dataReserve->where('situation', 'a')->count(),
                    'color' => 'darkgreen'
                ],
                [
                    'name' => 'Cadastro',
                    'y' => $dataReserve->where('situation', 'cd')->count(),
                    'color' => 'darkgreen'
                ],
                [
                    'name' => 'Pendente',
                    'y' => $dataReserve->where('situation', 'p')->count(),
                    'color' => 'darkorange'
                ],
                [
                    'name' => 'Assinado',
                    'y' => $dataAssigned->where('situation', 'as')->count(),
                    'color' => 'darkblue'
                ],
                [
                    'name' => 'Ass c/ Pend',
                    'y' => $dataAssigned->where('situation', 'ap')->count(),
                    'color' => 'darkblue'
                ],
                [
                    'name' => 'Ativ. Finais',
                    'y' => $dataAssigned->where('situation', 'af')->count(),
                    'color' => 'darkblue'
                ],
                [
                    'name' => 'Cancelados',
                    'y' => $dataReserveCanceledMonth->count() + $dataCanceledMonth->count(),
                    'color' => 'darkred'
                ],

            ],
            'month' => getCurrentMonth()
        ];
    }


    public function dataGraphContractCelebrated(Request $request)
    {
        $queryParams = [
            'type_goal' => !$request->get('type_goal') ? 'value' : $request->get('type_goal')
        ];

        $month = date('m');
        $year = date('Y');

        $goal = 0;

        // verifica se tem meta registrada no sistema
        $checkGoal = $this->systemGoalServiceCrud->findWhere(['name' => 'cc']);
        if (!$checkGoal->count()) {
            return [
                'error' => true,
                'message' => 'no goals found'
            ];
        }


        // verifica o tipo de meta solicitada
        if ($queryParams['type_goal'] === 'value') {
            // valor
            $goal = $checkGoal[0]['value'];
        } else {
            // percentual
            $getGoalPercent = $this->systemGoalServiceCrud->findWhere(['name' => 'cc', 'type' => 'percent']);

            if (!$getGoalPercent->count()) {
                return [
                    'error' => true,
                    'message' => 'no goal percent found'
                ];
            }

            // pego o valor de inativados do mês
            $closureContractsInactivatedMonth =  function ($query) use ($year, $month) {
                return $query->where('type_register', 'termination')
                            ->whereBetween('end_process', [$this->initDateCurrentMonth($year, $month), $this->endDateCurrentMonth($year, $month)])
                            ->whereIn('status', array('r', 'a', 'j', 'cej'));
            };
            $contractInactivatedMonth = $this->terminationContractServiceCrud->scopeQuery($closureContractsInactivatedMonth);
            $valueContractInactivated = $contractInactivatedMonth->sum('value');

            $goal = (float) round(($valueContractInactivated * ($getGoalPercent[0]['percent'] / 100)) + $valueContractInactivated, 2);
        }

        // verifica a meta no sistema
        $month = date('m');
        $year = date('Y');

        $closure = function ($query) use ($year, $month) {
            return $query->whereIn('situation', array('as', 'ap', 'af'))
                    ->whereBetween('conclusion', [$this->initDateCurrentMonth($year, $month), $this->endDateCurrentMonth($year, $month)]);
        };

        $getGoal = $this->reserveContractServiceCrud->scopeQuery($closure);



        return [
            'data' => [
                [
                    'name' => 'Meta Cumprida',
                    'y' => $getGoal->sum('value_negotiated'),
                    'color' => 'darkgreen'
                ],
                [
                    'name' => 'Meta a Cumprir',
                    'y' => $goal - $getGoal->sum('value_negotiated'),
                    'color' => 'darkred'
                ]
            ],
            'month' => getCurrentMonth(),
            'goal' => (float) $goal
        ];
    }
}
