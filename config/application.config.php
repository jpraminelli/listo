<?php

use Zend\Stdlib\ArrayUtils;

// ====================================================================================================================
// É inserido em todos os ambientes (desenvolvimento, staging, produção, etc.).
// ====================================================================================================================

// Nota:
// A ordem dos módulos é importante. Módulos que geram dependência para os outros módulos devem vir primeiro.

$config = array(
    'modules' => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'Shift',
        'Usuarios',
        'Noticias',
        'Relatorios',
        'Application',
        'ZfcTwig', // deve ser o último módulo. ver: https://github.com/ZF-Commons/ZfcTwig/issues/34
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './house',
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'cache_dir' => 'data/cache/',
    ),
);

$localAppConfigFilename = 'config/application.config.' . APP_ENV . '.php';
if (is_readable($localAppConfigFilename)) {
    $config = ArrayUtils::merge($config, require($localAppConfigFilename));
}

return $config;
