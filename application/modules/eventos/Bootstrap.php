<?php

class Eventos_Bootstrap extends Zend_Application_Module_Bootstrap
{

    const CSS_FILE = '../application/modules/eventos/views/scripts/eventos_bootstrap.css';
    const CSS_PATH = 'css/eventos_bootstrap.css';

    public function _initCssFile()
    {
        if (!is_file(self::CSS_PATH) || md5_file(self::CSS_PATH) != md5_file(self::CSS_FILE)) {
            copy(self::CSS_FILE, self::CSS_PATH);
            chmod(self::CSS_PATH, 0777);
        }
    }

}