<?php

class Lib_View_Helper_TimeFormat extends Zend_View_Helper_Abstract
{

    function timeFormat($string)
    {
        $time = time() - strtotime($string);

        $retorno = '';

        if ($time < (60 * 60)) {
            $retorno = '';
        } elseif ($time < (60 * 60 * 24)) {
            $retorno = 'Hoje';
        } elseif ($time < (60 * 60 * 24 * 2)) {
            $retorno = 'Ontem';
        } else {
            $meses = floor($time / (60 * 60 * 24 * 30));
            $dias = floor($time / (60 * 60 * 24));

            $retorno .= 'Há ';
            if ($meses == 1) {
                $retorno .= '1 mês';
            } else if ($meses > 1) {
                $retorno .= $meses . ' meses';
            }

            $retorno .= ' ' . ($meses >= 1 ? $dias % 30 : $dias) . ' dia' . ($dias > 1 ? 's' : '');
        }

        return $retorno;
    }

}