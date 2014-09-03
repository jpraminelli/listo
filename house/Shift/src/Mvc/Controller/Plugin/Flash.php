<?php

namespace Shift\Mvc\Controller\Plugin;

use Shift\Session\Container;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Flash extends AbstractPlugin
{
    const NAMESPACE_DEFAULT = 'default';
    const NAMESPACE_SUCCESS = 'success';
    const NAMESPACE_ERROR = 'error';
    const NAMESPACE_INFO = 'info';

    private $container;

    public function __construct()
    {
        $this->container = new Container('FLASH');
    }

    private function addMessage($text, $namespace)
    {
        $messages = $this->container->{$namespace};
        if (!is_array($messages)) {
            $messages = array();
        }
        $messages[] = $text;
        $this->container->{$namespace} = $messages;
    }

    public function message($text)
    {
        $this->addMessage($text, self::NAMESPACE_DEFAULT);
    }

    public function success($text)
    {
        $this->addMessage($text, self::NAMESPACE_SUCCESS);
    }

    public function error($text)
    {
        $this->addMessage($text, self::NAMESPACE_ERROR);
    }

    public function info($text)
    {
        $this->addMessage($text, self::NAMESPACE_INFO);
    }

    public function getMessages($namespace)
    {
        $messages = $this->container->{$namespace};
        unset($this->container->{$namespace});
        return $messages;
    }
}
