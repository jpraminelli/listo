<?php

require_once 'utils.php';

date_default_timezone_set('America/Sao_Paulo');

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));


if (getenv('APPLICATION_ENV')) {
    // A variável que define o ambiente pode ser forçada no .htaccess (ex: SetEnv APPLICATION_ENV development)
    define('APPLICATION_ENV', getenv('APPLICATION_ENV'));
} else {
    // Define application environment
    $host = $_SERVER['HTTP_HOST'];
    if ($host == '192.168.0.200') {
        define('APPLICATION_ENV', 'development');
    } else if ((strpos($host, 'localhost') !== false) || (strpos($host, '127.0.0.1') !== false) || (strpos($host, ':666') !== false)) {
        define('APPLICATION_ENV', 'local');
    } else if (strpos($host, 'magicwebdesign.com.br') !== false) {
        define('APPLICATION_ENV', 'testing');
    } else {
        define('APPLICATION_ENV', 'production');
    }
}

// Seta o nível de reporte de erros considerando o ambiente.
if (APPLICATION_ENV == 'production') {
    // Desativa o reporte de erros do PHP.
    //error_reporting(0);
    error_reporting(-1); //TODO: remover quando estiver em produção
} else {
    // Seta o nível de reporte de erros do PHP para o menos tolerante possível.
    error_reporting(-1);
}


// Ensure library/ is on include_path
set_include_path(
    implode(PATH_SEPARATOR, array(APPLICATION_PATH ."/../library"))
);

//pe(get_include_path());

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
$application->bootstrap()->run();
