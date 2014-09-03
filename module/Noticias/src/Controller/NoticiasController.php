<?php

namespace Noticias\Controller;

use Shift\SM;
use Zend\Mvc\Controller\AbstractActionController;

class NoticiasController extends AbstractActionController
{
    private $noticiasService;

    public function __construct()
    {
        $this->noticiasService = SM::get('noticias.service.noticias');
    }

    public function indexAction()
    {

        $noticias = $this->noticiasService->collection(array('visivel' => true), $this->params()->fromRoute('pagina', 1));
        
        return array(
            'noticias' => $noticias,
        );
    }

}
