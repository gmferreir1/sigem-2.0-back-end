<?php

namespace App\Traits\Generic;


use Carbon\Carbon;

trait DateTime
{
    protected $init_date_system = "1984-02-29";

    protected $end_date_system = "2099-02-29";

    public function getLastDateMonth(string $date) {
        $srt_date = strtotime($date);

        $last_day_month = date("t",$srt_date);
        $month = date("m", $srt_date);
        $year = date('Y', $srt_date);

        return $year . '-' . $month . '-' . $last_day_month;
    }

    public function getLastDay(string $date) {

        $dt = explode('-', $date);

        $month = $dt[1];
        $year = $dt[0];
        $lastDay = date("t", mktime(0,0,0,$month,'01',$year));

        return "$year-$month-$lastDay";
    }

    /**
     * Retorna o primeiro dia do mês anterior
     * @param $year
     * @param $month
     * @return string
     */
    public function initDatePreviousMonth($year, $month)
    {
        $date = Carbon::create($year, $month, 1);
        return $date->subMonth()->format('Y-m-d');
    }

    /**
     * Retorna o ultimo dia do mês anterior
     * @param $year
     * @param $month
     * @return false|string
     */
    public function endDatePreviousMonth($year, $month)
    {
        return date('Y-m-t', strtotime($this->initDatePreviousMonth($year, $month)));
    }

    /**
     * Retorna o primeiro dia do mês atual
     * @param $year
     * @param $month
     * @return string
     */
    protected function initDateCurrentMonth($year, $month)
    {
        return "$year-$month-01";
    }

    /**
     * Retorna o ultimo dia do mês atual
     * @param $month
     * @param $year
     * @return false|string
     */
    protected function endDateCurrentMonth($year, $month)
    {
        $lastDayMonth = date("t", mktime(0,0,0,$month,'01',$year));
        return "$year-$month-$lastDayMonth";
    }

    /**
     * Retorna o primeiro dia do próximo mês
     * @param $year
     * @param $month
     * @return string
     */
    protected function initDateNextMonth($year, $month)
    {
        $date = Carbon::create($year, $month, 1);
        return $date->addMonth()->format('Y-m-d');
    }

    /**
     * Retorna o Mês por extenso
     * @param string $date
     * @return string
     */
    protected function getMonthInFull(string $date)
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        return strftime('%B',  strtotime($date));
    }

}