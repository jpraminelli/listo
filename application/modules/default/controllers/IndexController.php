<?php

class Default_IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_session = Lib_Session_Namespace::instance();
    }

    public function indexAction()
    {
//        $this->_redirect('index.htm');
//        pe($this->getHelper('Layout'));
//        $this->getHelper('Layout')->setLayout('bootstrap');
    }

    public function infoAction()
    {
        if (IS_MOBILE) {
            pe('device: mobile');
        } else {
            pe('device: NOT mobile');
        }
    }

}