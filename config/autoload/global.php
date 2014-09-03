<?php

// ====================================================================================================================
// É inserido em todos os ambientes (desenvolvimento, staging, produção, etc.).
// ====================================================================================================================

define('APP_ID', 'projeto_padrao');
define('APP_NAME', 'Projeto padrão');
define('APP_VERSION', '1.12.0');

// PRODUÇÃO (cdn antigo)
define('URL_PROJETO_PADRAO_ASSETS', 'https://57b51c8731c547a3a497-2c1a224ead0cb66fbe89f83d0c91f8de.ssl.cf1.rackcdn.com/');

// HOMOLOGAÇÃO (dev - cdn antigo)
define('URL_PROJETO_PADRAO_DEV_ASSETS', '');


return array(
    // ================================================================================================================
    // PHP (verificar se é realmente necessário - talvez a configuração no php.ini seja suficiente neste caso).
    // ================================================================================================================
    // 'phpSettings' => array(
    //     'date.timezone' => 'America/Sao_Paulo',
    // ),
    // ================================================================================================================
    // Configuração comum do doctrine.
    // ================================================================================================================
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'charset' => 'utf8',
                ),
            ),
        ),
    ),
    // ================================================================================================================
    // Geração de cache para os templates (twig).
    // ================================================================================================================
    'zfctwig' => array(
        'environment_options' => array(
            'cache' => 'data/cache/templates',
            'auto_reload' => true
        ),
    ),
);
