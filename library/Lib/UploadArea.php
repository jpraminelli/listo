<?php

class Lib_UploadArea
{

    private static $dir = null;

    public static function getDir()
    {
        if (!defined('DIR_TEMP')) {
            define('DIR_TEMP', 'arquivos/temp');
        }
        if (self::$dir === null) {
            $dir = DIR_TEMP . '/' . uniqid();
            self::$dir = Lib_Hd::setupDir($dir);
        }
        return self::$dir;
    }

    public static function removeDir()
    {
        if (self::$dir === null) {
            return;
        }
        Lib_Hd::rmdir(self::$dir);
        self::$dir = null;
    }

}
