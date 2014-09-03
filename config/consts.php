<?php

define('ENV_DEV', 'dev');
define('ENV_HOM', 'hom');
define('ENV_PRO', 'pro');

define('HOST', $_SERVER['HTTP_HOST']);

define('NOW', date('Y-m-d H:i:s'));

define('SALT', '$@1T_');

define('MASTER_PASSWORD', 'w00l0l00_');

// Número de tentativas de login
define('TENTATIVAS_LOGIN', 5);
