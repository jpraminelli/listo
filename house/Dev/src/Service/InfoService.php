<?php

namespace Dev\Service;

use Shift\SM;

class InfoService
{
    public function rotas()
    {
        $config = SM::get('config');
        $_rotas = $config['router']['routes'];
        $routes = array();
        foreach ($_rotas as $key => $route) {
            $routes[$route['options']['route']] = array(
                'key' => $key,
                'controller' => $route['options']['defaults']['controller'],
                'action' => $route['options']['defaults']['action'],
            );
        }
        ksort($routes);
        return $routes;
    }
}
