<?php

class Lib_Session_Namespace
{

    private static $instance = null;

    /**
     * Retorna uma instância única (singleton) de Zend_Session_Namespace.
     * 
     * @return Zend_Session_Namespace 
     */
    public static function instance()
    {
        if (self::$instance == null) {
            self::$instance = new Zend_Session_Namespace(APPID);
        }
        return self::$instance;
    }

}
