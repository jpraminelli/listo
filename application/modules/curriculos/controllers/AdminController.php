<?php

class Curriculos_AdminController extends Curriculos_Library_Crud
{

    protected $_indexUrl = 'curriculos/admin';

    public function formAction()
    {
        // Em alguns casos, a requisição para este form pode partir do form de listas.
        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'curriculos/admin-listas/form') !== false) {
            $this->_backUrl = $_SERVER['HTTP_REFERER'];
        } else {
            // form de curriculos
            //nao sera permitido criar novos curriculos , se nao existir id direciona para a listagem
            $id = (int) $this->_getParam('id', 0);
            if (!isset($id) || $id == 0) {
                Lib_FlashMessage::info('Não é permitido cadastrar novos curriculos via admin!');
                $this->_redirect($this->_backUrl);
            }
        }
        parent::formAction();
    }

    public function popupFormAction()
    {
        header('Content-Type: text/html; charset=ISO-8859-1');
        $this->getHelper('Layout')->disableLayout(true);
        $this->_useFlashMessages = false;
        parent::formAction();
    }

    public function frameAction()
    {
        $this->getHelper('Layout')->disableLayout(true);
        parent::indexAction();
    }

    public function ajaxCurriculosPorCargosAction()
    {
        $this->getHelper('Layout')->disableLayout(true);
        $this->getHelper('ViewRenderer')->setNoRender(true);
        $curriculosTable = new Curriculos_Model_DbTable_Curriculos;
        $cargo_id = (int) $this->_getParam('cargo_id', '0');
        $quantidade = (int) $this->_getParam('quantidade', '10');
        $this->listaAjaxCurriculos($curriculosTable->porCargo($cargo_id, $quantidade));
    }

    public function ajaxCurriculosPorIdsAction()
    {
        $this->getHelper('Layout')->disableLayout(true);
        $this->getHelper('ViewRenderer')->setNoRender(true);
        $curriculosTable = new Curriculos_Model_DbTable_Curriculos;
        $ids = explode(';', trim($this->_getParam('ids', ''), '; '));
        $this->listaAjaxCurriculos($curriculosTable->listaParaBusca($ids));
    }

    private function listaAjaxCurriculos($rowset)
    {
        $response = array();
        if ($rowset) {
            $response['rowset'] = $rowset->toArray();
            foreach ($response['rowset'] as &$row) {
                $row['data_nascimento'] = date('d/m/Y', strtotime($row['data_nascimento']));
                $row['dh_atualizacao'] = date('d/m/Y H:i', strtotime($row['dh_atualizacao']));
                $row['lc_id'] = 'new_' . uniqid();
            }
        }
        die(Lib_Json::encode($response));
    }

    public function excluirAction()
    {
        Lib_FlashMessage::error('Não é possível excluir um currículo!');
        $this->_redirect($this->_indexUrl);
//        parent::excluirAction();
    }

    public function beforeDelete($id)
    {
//        pe('//TODO: deletar a informação relacionada...');
    }

    public function visualizarAction()
    {
        $id = (int) $this->_getParam('id', 0);
        $curriculo = $this->_model->visualizar($id);

        $this->view->headLink()
                ->appendStylesheet('css/print.css', array('media' => 'print'));

        if ($curriculo instanceof Zend_Db_Table_Row_Abstract) {
            $this->view->curriculo = $curriculo;

            $this->view->telefones = $this->_telefonesTable->listaPorCurriculo($curriculo->id);
            $this->view->cargos = $this->_cargosTable->listaPorCurriculoVisualizacao($curriculo->id);
            $this->view->escolaridades = $this->_escolaridadesTable->listaPorCurriculoVisualizacao($curriculo->id);
            $this->view->cursos = $this->_cursosTable->listaPorCurriculo($curriculo->id);
            $this->view->experiencias = $this->_experienciasTable->listaPorCurriculo($curriculo->id);
            $this->view->notas = $this->_notasTable->listaPorCurriculoVisualizacao($curriculo->id);
        } else {
            Lib_FlashMessage::error('Registro não encontrado!');
            $this->_redirect($this->_indexUrl);
        }
    }

}
