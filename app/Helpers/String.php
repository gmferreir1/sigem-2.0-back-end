<?php

function toLowerCase ($string) {

    if(gettype($string) == 'array') {
        foreach ($string as $key => $item) {

            if(gettype($string[$key]) == 'string') {
                $string[$key] = mb_strtolower($string[$key]);
            }

        }
        return $string;
    }

    if($string != null) {
        if(gettype($string) === 'string') {

            $string = mb_strtolower(trim($string));
        }
    }

    return $string;
}

function trimAndEncode($value)
{
    return $value != null ? trim(removeAccents(toLowerCase(encode($value)))) : null;
}

function removeAccents($string) {

    if(gettype($string) == 'array') {
        foreach ($string as $key => $item) {

            if(gettype($string[$key]) == 'string') {
                $string[$key] = mb_strtolower(preg_replace(
                    array("/(á|à|ã|â|ä)/",
                        "/(Á|À|Ã|Â|Ä)/",
                        "/(é|è|ê|ë)/",
                        "/(É|È|Ê|Ë)/",
                        "/(í|ì|î|ï)/",
                        "/(Í|Ì|Î|Ï)/",
                        "/(ó|ò|õ|ô|ö)/",
                        "/(Ó|Ò|Õ|Ô|Ö)/",
                        "/(ú|ù|û|ü)/",
                        "/(Ú|Ù|Û|Ü)/",
                        "/(ñ)/",
                        "/(Ñ)/","/(ç|Ç)/"),explode(" ","a A e E i I o O u U n N c Ç"), $string[$key]));
            }

        }
        return $string;
    }

    return preg_replace(
        array("/(á|à|ã|â|ä)/",
            "/(Á|À|Ã|Â|Ä)/",
            "/(é|è|ê|ë)/",
            "/(É|È|Ê|Ë)/",
            "/(í|ì|î|ï)/",
            "/(Í|Ì|Î|Ï)/",
            "/(ó|ò|õ|ô|ö)/",
            "/(Ó|Ò|Õ|Ô|Ö)/",
            "/(ú|ù|û|ü)/",
            "/(Ú|Ù|Û|Ü)/",
            "/(ñ)/",
            "/(Ñ)/","/(ç|Ç)/"),explode(" ","a A e E i I o O u U n N c Ç"),$string);
}


function uppercase($string = null) {
    if($string == null) {
        return null;
    }
    return strtoupper($string);
}

function toUcFirst($string) {
    if($string == null) {
        return null;
    }
    return ucfirst($string);
}

function encode($string) {

    if(mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1') == 'ISO-8859-1') {
        $string = utf8_encode($string);
    }


    if(!mb_detect_encoding($string, 'UTF-8')) {
        return utf8_encode($string);
    }
    return $string;
}

function onlyNumber($number) {
    return preg_replace("/[^0-9]/", "", $number);
}


function limitStr($string, $limit) {

    if (strlen($string) > $limit) {
        return substr($string, 0, $limit) . '...';
    }

    return $string;

}

function validMonth($month) {
    $valid_month = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
    if(in_array($month, $valid_month)) {
        return true;
    }
    return false;
}

function validYear($year) {
    if(!preg_match('/^[0-9]+$/', $year)) {
        return false;
    }

    if(strlen($year) != 4) {
        return false;
    }

    return true;
}

function validGoal($goal) {
    if ($goal == null || $goal < 0 || $goal > 100) {
        return false;
    }

    return true;
}

/**
 * Retorna o status do modulo de inativação de contrato
 * @param $status
 * @return string
 */
function getStatusInactivatedContract(string $status) : string {

    if ($status === 'p') {
        return 'Pendente';
    }

    if ($status === 'r') {
        return 'Resolvido';
    }

    if ($status === 'a') {
        return 'Acordo';
    }

    if ($status === 'j') {
        return 'Justiça';
    }

    if ($status === 'cej') {
        return 'Cob.Ext.Jud';
    }

    if ($status === 'c') {
        return 'Cancelado';
    }
}



function getTypeImmobile($type){

    switch ($type) {
        case 'apartamento':
            $data = 'ap';
            break;
        case 'apartamento cobert.':
            $data = 'apc';
            break;
        case 'aparthotel':
            $data = 'aph';
            break;
        case 'area comercial':
            $data = 'ac';
            break;
        case 'area industrial':
            $data = 'ai';
            break;
        case 'barracao':
            $data = 'br';
            break;
        case 'box':
            $data = 'box';
            break;
        case 'casa comercial':
            $data = 'cs';
            break;
        case 'casa condominio':
            $data = 'cs';
            break;
        case 'casa residencial':
            $data = 'cs';
            break;
        case 'casa sobrado':
            $data = 'cs';
            break;
        case 'chacara':
            $data = 'ch';
            break;
        case 'galpao':
            $data = 'gp';
            break;
        case 'garagem':
            $data = 'ga';
            break;
        case 'imovel rural':
            $data = 'ir';
            break;
        case 'kitinete':
            $data = 'kt';
            break;
        case 'lote':
            $data = 'lt';
            break;
        case 'lote em condominio':
            $data = 'lt';
            break;
        case 'ponto comercial':
            $data = 'pc';
            break;
        case 'sala':
            $data = 'sl';
            break;
        case 'salao comercial':
            $data = 'sl';
            break;
        case 'sitio':
            $data = 'st';
            break;
        case 'sobreloja':
            $data = 'pc';
            break;
        case 'terreno comercial':
            $data = 'tc';
            break;
        case 'terreno industrial':
            $data = 'ti';
            break;
        case 'flat':
            $data = 'fl';
            break;
        default:
            $data = '#';
    }

    return $data;
}


function getSituationName($status) {
    if ($status === 'p') {
        return 'Pendente';
    }
    if ($status === 'a') {
        return 'Andamento';
    }
    if ($status === 'r') {
        return 'Reserva';
    }
    if ($status === 'as') {
        return 'Assinado';
    }
    if ($status === 'ap') {
        return 'Ass c/ Pen';
    }
    if ($status === 'c') {
        return 'Cancelado';
    }
}



