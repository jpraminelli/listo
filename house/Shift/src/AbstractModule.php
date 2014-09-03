<?php

namespace Shift;

abstract class AbstractModule
{

    protected $__dir__;
    protected $__namespace__;

    public function getConfig()
    {
        return include $this->__dir__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    //$this->__namespace__ => $this->__dir__ . '/src/' . $this->__namespace__,
                    $this->__namespace__ => $this->__dir__ . '/src',
                ),
            ),
        );
    }

}
