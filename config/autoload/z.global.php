<?php

// ====================================================================================================================
// É inserido (por último) em todos os ambientes (desenvolvimento, staging, produção, etc.).
// ====================================================================================================================

//if (USE_CDN) {
//    // define('APPLICATION_ASSETS', '//...');
//    define('BOOTSTRAP_ASSETS', '//netdna.bootstrapcdn.com/bootstrap/3.0.3');
//    define('JQUERY_ASSETS', '//code.jquery.com');
//} else {
//    define('BOOTSTRAP_ASSETS', WWWROOT . '/cloud/assets/bootstrap');
//    define('JQUERY_ASSETS', WWWROOT . '/cloud/assets/jquery');
//}

// --------------------------------------------------------------------------------------------------------------------
// URL local dos assets
// --------------------------------------------------------------------------------------------------------------------
define('LOCAL_ASSETS_URL', WWWROOT . '/cloud/assets/');

// --------------------------------------------------------------------------------------------------------------------
// Define se o acesso será local ou do cloud (considerando produção e homologação)
// Também define o nome dos containers para as operações de upload
// --------------------------------------------------------------------------------------------------------------------
if (APP_ENV == ENV_PRO) {
    // ------------------------------------------------------------------------
    // PRODUÇÃO
    // ------------------------------------------------------------------------
    // Assets (o acesso sempre será do cloud)
    define('ASSETS_URL', URL_PROJETO_PADRAO_ASSETS);
    
    // Containers
    define('ITAU_ENDO_ASSETS', 'itau_endo_assets');
    
} else if (APP_ENV == ENV_HOM) {
    // ------------------------------------------------------------------------
    // HOMOLOGAÇÃO
    // ------------------------------------------------------------------------
    if (CLOUD_ENABLED) {
        define('ASSETS_URL', URL_PROJETO_PADRAO_ASSETS);
    } else {
        define('ASSETS_URL', LOCAL_ASSETS_URL);
    }
    // Containers
    define('ITAU_ENDO_ASSETS', 'itau_endo_dev_assets');

} else {
    // ------------------------------------------------------------------------
    // DEVIL e LOCAL
    // ------------------------------------------------------------------------
    // Ambientes locais podem variar de acordo com a definição de CLOUD_ENABLED
    if (CLOUD_ENABLED) {
        // utiliza o cloud de produção
        define('ASSETS_URL', URL_PROJETO_PADRAO_ASSETS);
    } else {
        define('ASSETS_URL', LOCAL_ASSETS_URL);
    }
}

// --------------------------------------------------------------------------------------------------------------------
// CSS
// --------------------------------------------------------------------------------------------------------------------
if (ASSETS_URL == LOCAL_ASSETS_URL) {
    define('CSS_estilo', ASSETS_URL . 'css__estilo.css');
} else {
    define('CSS_estilo', ASSETS_URL . 'css__estilo.css');
}

// --------------------------------------------------------------------------------------------------------------------
// JS
// --------------------------------------------------------------------------------------------------------------------
define('JS_jquery', ASSETS_URL . 'js__jquery-1.10.2.min.js');
define('JS_jquery_remoteform', ASSETS_URL . 'js__jquery.remoteform.js');

return array();
