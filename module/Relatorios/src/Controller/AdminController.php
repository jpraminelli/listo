<?php

namespace Relatorios\Controller;

use Shift\SM;
use Zend\Mvc\Controller\AbstractActionController;

class AdminController extends AbstractActionController
{
    private $relatoriosService;

    public function __construct()
    {
        $this->relatoriosService = SM::get('relatorios.service.relatorios');
    }

    public function indexAction()
    {

        $emPesquisa = $this->emPesquisa();
        
        $relatorio = $this->relatoriosService->allNoticas($this->params()->fromQuery());
        
        $form = SM::get('relatorios.form.relatorio_search');
        $form->setData($this->params()->fromQuery());
        
        return array(
            'emPesquisa' => $emPesquisa,
            'form' => $form,
            'relatorio' => $relatorio,
        );
    }

    private function emPesquisa()
    {
        foreach ($this->params()->fromQuery() as $key => $value) {
            if ($value != '') {
                return true;
            }
        }
        return false;
    }

}
