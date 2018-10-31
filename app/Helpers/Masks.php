<?php

function format_phone($phone) {
    $phone = preg_replace("/[^0-9]/", "", $phone);

    if (strlen($phone) == 10)
        return preg_replace("/(\d{2})(\d{4})(\d{4})/", "($1)$2-$3", $phone);
    elseif (strlen($phone) > 10)
        return preg_replace("/(\d{2})(\d{5})(\d{4})/", "($1)$2-$3", $phone);
    else
        return $phone;
}

function mask($val, $mask) {
    $maskared = '';

    $k = 0;

    for ($i = 0; $i <= strlen($mask) - 1; $i++) {
        if ($mask[$i] == '#') {
            if (isset($val[$k]))
                $maskared .= $val[$k++];
        } else {
            if (isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

function numberFormat($value) {
    return number_format($value, 2, ',', '.');
}