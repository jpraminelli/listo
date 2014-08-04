<?php

class Projeto_Controller_Plugin_LayoutSwitcher extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $layout = Zend_Layout::getMvcInstance();

        $controller = $request->getControllerName();
        if (substr($controller, 0, 5) == 'admin') {
            $layout->setLayout('admin');
        } else if (substr($controller, 0, 8) == 'extranet') {
            $layout->setLayout('extranet');
        }
        $layout->getView()->headTitle()->setSeparator(' - ')
                ->append(Lib_Config_Ini::instance()->appname);
    }

    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        /*
          $session = Lib_Session_Namespace::instance();
          if (isset($session->dashboard)) {
          if ($session->dashboard == 'admin') {
          define('DASHBOARD', 'admin');
          } else if ($session->dashboard == 'extranet') {
          define('DASHBOARD', 'extranet');
          }
          }
         */
        if (!defined('DASHBOARD')) {
            define('DASHBOARD', 'admin');
        }
    }

}
