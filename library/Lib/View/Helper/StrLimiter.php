<?php

class Lib_View_Helper_StrLimiter extends Zend_View_Helper_Abstract
{

    public function StrLimiter($str, $lim, $end = "...")
    {
        return strlen(strip_tags($str)) > $lim ? substr(strip_tags($str), 0, strrpos(substr(strip_tags($str), 0, ($lim - strlen($end))), ' ')) . $end : strip_tags($str);
    }

}