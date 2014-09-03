<?php

namespace Application\Controller;

use Shift\SM;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public $renderer;


    public function __construct()
    {
        $this->renderer = SM::get('Zend\View\Renderer\PhpRenderer');
    }

    public function indexAction()
    {
        //TITLE, DESCRIPTION E KEYWORDS
        $this->renderer->headTitle('Título a definir ainda !!!!!!!!!!!!');
        $this->renderer->headMeta()->appendName('keywords', 'sem keywords por enquanto');
        $this->renderer->headMeta()->appendName('description', 'sem descripiton por enquanto');
        return new ViewModel();
    }
    
}
