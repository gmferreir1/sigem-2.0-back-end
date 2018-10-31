<?php

use Carbon\Carbon;

function daysDurationProcess($init_date, $end_date) {
    $date1 = Carbon::createFromFormat('Y-m-d', $init_date);
    $date2 = Carbon::createFromFormat('Y-m-d', $end_date);
    return $date1->diffInDays($date2);
}

function dateExtensive($date = null) {
    if(!$date) {
        $date = date('Y-m-d');
    }
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    return strftime("%d", strtotime($date)) . ' de ' . ucwords(strftime("%B", strtotime($date))) . ' de ' . ucwords(strftime("%Y", strtotime($date)));
}

function getCurrentMonth($date = null) {
    if(!$date) {
        $date = date('Y-m-d');
    }
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    return ucwords(strftime("%B", strtotime($date)));
}

/**
 * Recebe a quantidade de dias como parâmetro e retorna os anos meses e dias de acordo a data
 * @param $day
 * @return string
 */
function medianDays(int $day) {
    $time = $day*24*3600;

    $return    = array();
    $years       = floor($time/(86400*365));
    $time       = $time%(86400*365);
    $month      = floor($time/(86400*30));
    $time       = $time%(86400*30);
    $days       = floor($time/86400);
    $time       = $time%86400;
    $hours      = floor($time/(3600));
    $time       = $time%3600;
    $minutes    = floor($time/60);
    $seconds   = $time%60;
    if($years>0)  $return[] = $years  . ' ano'    . ($years > 1 ? 's' : ' ');
    if($month>0)     $return[] = $month     . ' mes'    . ($month > 1 ? 'es' : ' ');
    if($days>0)  $return[] = $days  . ' dia'    . ($days > 1 ? 's' : ' ');
    /*if($hours>0)     $return[] = $hours     . ' hora'   . ($hours > 1 ? 's' : ' ');
    if($minutes>0)   $return[] = $minutes   . ' minuto'     . ($minutes > 1 ? 's' : ' ');
    if($seconds>0)  $return[] = $seconds  . ' segundo'    . ($seconds > 1 ? 's' : ' ');
    */
    return implode(' e ',$return);
}


/**
 * Converte dias em meses e dias
 * @param $time
 * @return string
 */
function dayToMonth($time){
    $time = $time * 24 * 3600;
    $years = floor($time / (60*60*24*365));
    $time-=$years*60*60*24*365;
    $months = floor($time/(60*60*24*30));
    $time-=$months*60*60*24*30;
    $days = floor($time/(60*60*24));
    $time-=$days*60*60*24;
    $hours = floor($time/(60*60));
    $time-=$hours*60*60;
    $seconds = floor($time/60);
    return ($years>0?$years.' ano'. ($years>1?'s ':' '):'') .
        ($months>0?$months.' mes'.($months>1?'es ':' '):'') . ' e '.
        ($days>0?$days.' dia' .($days>1?'s ':' '):'');
}

/**
 * @param $date
 * @return false|string
 */
function formatDate($date) {
    if ($date) {
        return date('d/m/Y', strtotime($date));
    }
}