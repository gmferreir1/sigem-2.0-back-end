<?php

function zeroToLeft($number) {
    if($number < 10) {
        return str_pad($number, 2, '0', STR_PAD_LEFT);
    }
    return $number;
}

function calcTxAdm($value, $taxa) {

    if($value and $taxa) {
        return ((float) $value / 100) * (int) $taxa;
    }
    return 0;
}

function humanFileSize($size, $precision = 2) {
    static $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $step = 1024;
    $i = 0;
    while (($size / $step) > 0.9) {
        $size = $size / $step;
        $i++;
    }

    return round($size, $precision).$units[$i];
}