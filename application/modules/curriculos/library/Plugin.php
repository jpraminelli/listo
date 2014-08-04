<?php

class Curriculos_Library_Plugin extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // Define constantes que indicam o id e tipo de usuário
        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            if (!defined('USER_ID')) {
                define('USER_ID', $identity->id);
            }
            if (!defined('IS_ADMIN')) {
                define('IS_ADMIN', (isset($identity->perfil) && $identity->perfil == 'A'));
            }
        } else {
            if (!defined('IS_ADMIN')) {
                define('USER_ID', null);
                define('IS_ADMIN', false);
            }
        }
        // Define constantes para o que está sendo executado (front ou back-end).
        // Serão utilizadas em outras partes do módulo de currículos.
        $controller = $request->getControllerName();
        if (!defined('IN_BACKEND')) {
            define('IN_BACKEND', (substr($controller, 0, 5) == 'admin'));
        }
        if (!defined('IN_FRONTEND')) {
            define('IN_FRONTEND', !IN_BACKEND);
        }
    }

}
