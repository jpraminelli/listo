<?php

class Curriculos_EditarController extends Curriculos_Library_Crud
{

    public function indexAction()
    {
        // Anula a ação 'index' presente na superclasse
        $this->_response->setRedirect('form');
    }

    public function excluirAction()
    {
        // Anula a ação 'excluir' presente na superclasse
        $this->_response->setRedirect('form');
    }

}
