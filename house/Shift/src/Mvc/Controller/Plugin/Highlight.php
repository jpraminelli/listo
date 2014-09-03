<?php

namespace Shift\Mvc\Controller\Plugin;

use Shift\Session\Container;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Highlight extends AbstractPlugin
{
    const NAMESPACE_HIGHLIGHT = 'highlight';

    private $container;

    public function __construct()
    {
        $this->container = new Container('HIGHLIGHT');
    }

    private function __invoke($item)
    {
        $items = $this->container->{self::NAMESPACE_HIGHLIGHT};
        if (!is_array($items)) {
            $items = array();
        }
        $items[] = $item;
        $this->container->{self::NAMESPACE_HIGHLIGHT} = $items;
    }

    public function getItems()
    {
        $items = $this->container->{self::NAMESPACE_HIGHLIGHT};
        unset($this->container->{self::NAMESPACE_HIGHLIGHT});
        return $items;
    }
}
