<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initLocale()
    {
        Zend_Registry::set('Zend_Locale', new Zend_Locale('pt_BR'));
    }

}
