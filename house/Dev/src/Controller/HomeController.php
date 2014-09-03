<?php

namespace Dev\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class HomeController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/dev');
    }
}
