<?php

class Lib_Ip
{

    public static function formataMascara($ip)
    {
        $partes = explode('.', $ip);
        foreach ($partes as &$parte) {
            $parte = str_pad($parte, 3, '0', STR_PAD_LEFT);
        }
        return implode('.', $partes);
    }

}
