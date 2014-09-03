<?php

namespace Shift\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Shift\SM;

class BodyClass extends AbstractHelper
{

    public function __invoke()
    {
        $routeMatch = SM::get('application')->getMvcEvent()->getRouteMatch();
        if (!$routeMatch) {
            return '';
        }
        $rota = str_replace('|', '_', $routeMatch->getMatchedRouteName());
        return $rota;
    }

}
