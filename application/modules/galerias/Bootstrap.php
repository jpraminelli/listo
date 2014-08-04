<?php

class Galerias_Bootstrap extends Zend_Application_Module_Bootstrap
{

    const CSS_FILE = '../application/modules/galerias/views/scripts/galerias_bootstrap.css';
    const CSS_PATH = 'css/galerias_bootstrap.css';

    public function _initCssFile()
    {
        if(!is_file(self::CSS_PATH) || md5_file(self::CSS_PATH) != md5_file(self::CSS_FILE)) {
            copy(self::CSS_FILE, self::CSS_PATH);
            chmod(self::CSS_PATH, 0777);
        }
    }

}