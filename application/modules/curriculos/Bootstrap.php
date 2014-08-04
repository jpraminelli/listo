<?php

class Curriculos_Bootstrap extends Zend_Application_Module_Bootstrap
{

    protected function _initModule()
    {
        $this->getResourceLoader()->addResourceType('library', 'library', 'Library');
        Zend_Controller_Front::getInstance()->registerPlugin(new Curriculos_Library_Plugin());

        $options = new Zend_Config_Ini(realpath(__DIR__) . '/configs/config.ini', APPLICATION_ENV);

        $config = Lib_Config_Ini::instance();
        $config->merge($options);
    }

}