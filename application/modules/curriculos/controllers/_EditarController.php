<?php

class Curriculos_EditarController extends Curriculos_Library_Crud
{

    public function indexAction()
    {
        // Anula a a��o 'index' presente na superclasse
        $this->_response->setRedirect('form');
    }

    public function excluirAction()
    {
        // Anula a a��o 'excluir' presente na superclasse
        $this->_response->setRedirect('form');
    }

}
