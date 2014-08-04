<?php

class Lib_Controller_Plugin_Constantes extends Zend_Controller_Plugin_Abstract
{

    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $config = Lib_Config_Ini::instance();
//        if (APPLICATION_ENV != 'testing') {
//            $dominio = 'http://' . $_SERVER['HTTP_HOST'];
//            define('WWWROOT', $dominio . $request->getBaseUrl() . '/');
//        } else {
//            if (!defined('WWWROOT')) {
//                define('WWWROOT', '/');
//            }
//        }
        $dominio = 'http://' . $_SERVER['HTTP_HOST'];
        define('WWWROOT', $dominio . $request->getBaseUrl() . '/');
        if (!defined('IS_MOBILE')) {
            // Esta validação é super simples e funciona com o Android.
            // Contudo, deve-se verificar posteriormente a maneira correta de identificar o dispositivo.
            // Parece ser chato, pois depende de uma configuração na aplicação.
            // Ver: http://framework.zend.com/manual/en/zend.http.user-agent.html
            define('IS_MOBILE', isset($_SERVER["HTTP_X_WAP_PROFILE"]));
        }
        if (!defined('APPNAME')) {
            define('APPNAME', $config->appname);
        }
        if (!defined('APPMAIL')) {
            define('APPMAIL', $config->appmail);
        }
    }

}
