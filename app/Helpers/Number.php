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