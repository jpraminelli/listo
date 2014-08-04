<?php

class Lib_Logger
{

    private static $instance = null;

    /**
     * Retorna uma instância única (singleton) de um Zend_Log preparado para gerar logs em /logs.
     * 
     * @return Zend_Log
     */
    public static function instance()
    {
        if (self::$instance == null) {
            $dir = Lib_Hd::setupDir('../logs');
            $file = $dir . date('Y-m-d') . '-log.txt';
            $writer = new Zend_Log_Writer_Stream($file);
            self::$instance = new Zend_Log($writer);
        }
        chmod($file, 0777);
        return self::$instance;
    }

}
