<?php

namespace Dev\Navigation;

use Zend\Navigation\Service\AbstractNavigationFactory;

class NavigationFactory extends AbstractNavigationFactory
{
    protected function getName()
    {
        return 'dev';
    }
}
