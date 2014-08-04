<?php

class Projeto_Controller_Plugin_Constantes extends Zend_Controller_Plugin_Abstract
{

    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        if (!defined('APPID')) {
            define('APPID', Lib_Config_Ini::instance()->appid);
        }

        if (!defined('DIR_ARQUIVOS')) {
            define('DIR_ARQUIVOS', 'arquivos');
        }

        if (!defined('DIR_TEMP')) {
            define('DIR_TEMP', DIR_ARQUIVOS . '/temp');
        }

        if (!defined('DIR_NOTICIAS')) {
            define('DIR_NOTICIAS', DIR_ARQUIVOS . '/noticias');
        }

        if (!defined('DIR_GALERIAS')) {
            define('DIR_GALERIAS', DIR_ARQUIVOS . '/galerias');
        }

        if (!defined('DIR_EVENTOS')) {
            define('DIR_EVENTOS', DIR_ARQUIVOS . '/eventos');
        }

        if (!defined('DIR_FOTOS')) {
            define('DIR_FOTOS', DIR_ARQUIVOS . '/curriculos_fotos');
        }
        
        if (!defined('DIR_BANNERS')) {
            define('DIR_BANNERS', DIR_ARQUIVOS . '/banners');
        }
        
        

        // Cria os diretórios necessários
        if (!is_dir(DIR_ARQUIVOS)) {
            mkdir(DIR_ARQUIVOS, 0777, true);
            chmod(DIR_ARQUIVOS, 0777);
        }

        if (!is_dir(DIR_TEMP)) {
            mkdir(DIR_TEMP, 0777, true);
            chmod(DIR_TEMP, 0777);
        }

        if (!is_dir(DIR_NOTICIAS)) {
            mkdir(DIR_NOTICIAS, 0777, true);
            chmod(DIR_NOTICIAS, 0777);
        }

        if (!is_dir(DIR_GALERIAS)) {
            mkdir(DIR_GALERIAS, 0777, true);
            chmod(DIR_GALERIAS, 0777);
        }

        if (!is_dir(DIR_EVENTOS)) {
            mkdir(DIR_EVENTOS, 0777, true);
            chmod(DIR_EVENTOS, 0777);
        }

        if (!is_dir(DIR_FOTOS)) {
            mkdir(DIR_FOTOS, 0777, true);
            chmod(DIR_FOTOS, 0777);
        }
        if (!is_dir(DIR_BANNERS)) {
            mkdir(DIR_BANNERS, 0777, true);
            chmod(DIR_BANNERS, 0777);
        }
    }

}
