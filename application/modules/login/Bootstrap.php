<?php

class Login_Bootstrap extends Zend_Application_Module_Bootstrap
{

    protected function _initRoutes()
    {
        $options = new Zend_Config_Ini(realpath(__DIR__) . '/configs/routes.ini', APPLICATION_ENV);
        $this->setOptions($options->toArray());
    }

}