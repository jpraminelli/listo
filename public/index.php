<?php

chdir(dirname(__DIR__));

include 'config/consts.php';
include 'config/env.php';

if (!defined('APP_ENV')) {
    define('APP_ENV', ENV_PRO);
}

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Composer autoloading
if (file_exists('vendor/autoload.php')) {
    $loader = include 'vendor/autoload.php';
}

include 'vendor/zendframework/zendframework/library/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array(
    'Zend\Loader\StandardAutoloader' => array(
        'autoregister_zf' => true
    )
));

if (!class_exists('Zend\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Não foi possível encontrar o ZF2. Rodar `php composer.phar install`.');
}

Zend\Mvc\Application::init(require 'config/application.config.php')->run();
