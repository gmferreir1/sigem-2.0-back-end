<?php

function getSituationNameReserve(string $situation)
{
    if ($situation === 'r') {
        return 'reserva';
    }
    if ($situation === 'd') {
        return 'documentacao';
    }
    if ($situation === 'a') {
        return 'análise';
    }
    if ($situation === 'cd') {
        return 'cadastro';
    }
    if ($situation === 'p') {
        return 'pendente';
    }
    if ($situation === 'as') {
        return 'assinado';
    }
    if ($situation === 'ap') {
        return 'assinado c/ pendencia';
    }
    if ($situation === 'af') {
        return 'at. finais';
    }
    if ($situation === 'c') {
        return 'cancelado';
    }
}