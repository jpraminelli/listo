<?php

namespace Shift\Session;

use Zend\Session\Container as ZendContainer;

class Container extends ZendContainer
{

    public function __construct($name = null, $manager = null)
    {
        $prefix = preg_replace('/[^a-z0-9]/', '', strtolower(__DIR__));
        if ($name == null) {
            $name = 'DEFAULT';
        }
        $name = "{$prefix}__{$name}";
        parent::__construct($name, $manager);
    }

}
