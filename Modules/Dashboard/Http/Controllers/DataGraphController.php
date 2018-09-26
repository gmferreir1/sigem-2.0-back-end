<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Traits\Generic\DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Register\Services\ReserveContract\ReserveContractServiceCrud;

class DataGraphController extends Controller
{
    use DateTime;

    /**
     * @var ReserveContractServiceCrud
     */
    private $reserveContractRepository;

    public function __construct(ReserveContractServiceCrud $reserveContractRepository)
    {
        $this->reserveContractRepository = $reserveContractRepository;
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


        $dataReserve = $this->reserveContractRepository->scopeQuery($closureReserve);
        $dataAssigned = $this->reserveContractRepository->scopeQuery($closureAssigned);
        $dataReserveCanceledMonth = $this->reserveContractRepository->scopeQuery($closureReserveCanceledMonth);
        $dataCanceledMonth = $this->reserveContractRepository->scopeQuery($closureCanceledMonth);


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
}
