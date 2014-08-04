<?php

class Curriculos_AdminCronController extends Zend_Controller_Action
{

    public function indexAction()
    {
        //desabilita layout e view
        $this->getHelper('Layout')->disableLayout(true);
        $this->getHelper('ViewRenderer')->setNoRender(true);
        $cron = new Curriculos_Model_Cron();
        $cron->executa();
    }

}