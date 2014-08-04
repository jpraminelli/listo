<?php

class Lib_Config_Ini
{

    private static $instance = null;

    /**
     * Retorna uma instância única (singleton) de Zend_Config_Ini.
     * 
     * @return Zend_Config_Ini 
     */
    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV, array('allowModifications' => true));
        }
        return self::$instance;
    }

}
