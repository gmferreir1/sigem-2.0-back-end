<?php

namespace Modules\Register\Services\ReserveContract;

use App\Traits\Generic\DateTime;
use App\Traits\Generic\Printer;
use Carbon\Carbon;
use Modules\RegisterReserve\Services\ReserveContractQuantityService;

class ReserveContractPrinterService
{

    use Printer, DateTime;

    /**
     * @var ReserveContractQuantityService
     */
    private $reserveContractQuantityService;

    public function __construct(ReserveContractQuantityService $reserveContractQuantityService)
    {
        $this->reserveContractQuantityService = $reserveContractQuantityService;
    }


    /**
     * @param array $data
     * @param string $typePrinter
     * @param array $filter
     * @return array
     */
    public function generatePrinter(array $data, string $typePrinter, array $filter)
    {
        if ($typePrinter == 'reserve_list') {
            return $this->reserveList($data, $filter);
        }

        if ($typePrinter == 'contract_celebrated') {
            return $this->contractCelebrated($data, $filter);
        }

        if ($typePrinter == 'reserve_tracking') {
            return $this->monitoringReserve($filter['year'], $filter['month']);
        }

        if ($typePrinter == 'reserve_canceled') {
            return $this->reserveCanceled($data, $filter);
        }
    }

    /**
     * Relatório lista de reserva
     * @param array $data
     * @param array $filter
     * @return array
     */
    private function reserveList(array $data, array $filter)
    {

        $dataPrint = [
            'data' => $data,
            'period' => $this->getPeriod($filter)
        ];

        $viewName = 'register::reserve.printer.MonitoringListReserve';

        return $this->printer($dataPrint, $viewName, 'landscape');
    }

    /**
     * @param array $data
     * @param array $filter
     * @return array
     */
    private function contractCelebrated(array $data, array $filter)
    {
        $dataPrint = [
            'data' => $data,
            'period' => $this->getPeriod($filter),
            'report_qt' => $this->reserveContractQuantityService->generateReportQtContractCelebrated($data),
            'median' => $this->reserveContractQuantityService->timeMedian($data)
        ];

        $viewName = 'register::reserve.printer.ReportContractCelebrated';
        return $this->printer($dataPrint, $viewName, 'landscape');
    }

    /**
     * @param string $year
     * @param string $month
     * @return array
     */
    private function monitoringReserve(string $year, string $month)
    {

        $yearReport = $year;
        $monthReport = $month;
        $dataPrint = $this->reserveContractQuantityService->getReportMonitoringReserve($monthReport, $yearReport);
        $dataPrint['year'] = $yearReport;

        $viewName = 'register::reserve.printer.MonitoringReserve';
        return $this->printer($dataPrint, $viewName);

    }

    /**
     * @param array $data
     * @param array $filter
     * @return array
     */
    private function reserveCanceled(array $data, array $filter)
    {

        $dataPrint = [
            'data' => $data,
            'period' => $this->getPeriod($filter),
            'report_qt' => $this->reserveContractQuantityService->reasonsCancel($data),
            'median' => $this->reserveContractQuantityService->timeMedian($data)
        ];

        $viewName = 'register::reserve.printer.ReportReserveCanceled';
        return $this->printer($dataPrint, $viewName, 'portrait');
    }

    /**
     * Retorna o periodo para o cabeçalho da impressão
     * @param array $filter
     * @return string
     */
    private function getPeriod(array $filter)
    {
        if ($filter['init_date'] == $this->init_date_system || $filter['end_date'] == $this->end_date_system) {
            $period = "Geral";
        } else {
            $initDate = Carbon::createFromFormat('Y-m-d', $filter['init_date'])->format('d/m/Y');
            $endDate = Carbon::createFromFormat('Y-m-d', $filter['end_date'])->format('d/m/Y');
            $period = "$initDate a $endDate";
        }

        return $period;
    }
}