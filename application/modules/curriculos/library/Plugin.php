<?php

class Curriculos_Library_Plugin extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // Define constantes que indicam o id e tipo de usu�rio
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
        // Define constantes para o que est� sendo executado (front ou back-end).
        // Ser�o utilizadas em outras partes do m�dulo de curr�culos.
        $controller = $request->getControllerName();
        if (!defined('IN_BACKEND')) {
            define('IN_BACKEND', (substr($controller, 0, 5) == 'admin'));
        }
        if (!defined('IN_FRONTEND')) {
            define('IN_FRONTEND', !IN_BACKEND);
        }
    }

}
