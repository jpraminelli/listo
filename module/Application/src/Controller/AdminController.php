<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Shift\SM;

class AdminController extends AbstractActionController
{

    public function indexAction()
    {
        // funcao basica para disparo de emails
        //SM::get('application.mailer.application')->enviaEmail();
        
        return new ViewModel();
    }
    

}
