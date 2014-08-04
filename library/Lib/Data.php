<?php

class Lib_Data
{

    public static function extenso($data, $locale = null)
    {
        $extenso = new Zend_Date($data, false, $locale);
        return utf8_decode($extenso->toString(Zend_Date::DATE_FULL, 'pt_BR'));
    }

    public static function abreviado($data, $locale = null)
    {
        $extenso = new Zend_Date($data, false, $locale);
        return utf8_decode($extenso->toString(Zend_Date::DATE_LONG, 'pt_BR'));
    }

    public static function isDate($data)
    {
        // Este método existe porque o validador de datas do form e o zend_date fazem 
        // considerações diferentes sobre a validação das datas. Algumas coisas "passam"
        // e são imediatamente "distorcidas" pelo zend_date.
        if (strlen($data) != 10) {
            return false;
        }
        /*
        list ($dia, $mes, $ano) = explode('/', $data);
        if (strlen($dia) != 2 || strlen($mes) != 2 || strlen($ano) != 4) {
            return false;
        }
        if (!is_numeric($dia) || !is_numeric($mes) || !is_numeric($ano)) {
            return false;
        }
        if ((int) $ano < 1000) {
            return false;
        }
         */
        return Zend_Date::isDate($data);
    }

}
