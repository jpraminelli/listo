<?php

namespace Dev\Controller;

use Shift\SM;
use Dev\Service\InfoService;
use Zend\Mvc\Controller\AbstractActionController;

class InfoController extends AbstractActionController
{
    private $infoService;

    public function __construct()
    {
        $this->infoService = SM::get('dev.service.info');
    }

    public function rotasAction()
    {
        $this->layout('layout/dev');
        $rotas = $this->infoService->rotas();
        return array('rotas' => $rotas);
    }
}
