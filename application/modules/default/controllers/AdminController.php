<?php

class Default_AdminController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $this->view->usuario = Zend_Auth::getInstance()->getIdentity();
    }

    public function cronAction()
    {
        $modelCron = new Default_Model_Cron();
        $modelCron->executa();
    }

}
