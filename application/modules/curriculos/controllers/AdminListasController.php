<?php

class Curriculos_AdminListasController extends Lib_Controller_Crud
{

    protected $_indexUrl = 'curriculos/admin-listas';
    protected $_indexActionTitle = 'Administração de listas';
    protected $_formActionTitleNew = 'Nova lista';
    protected $_formActionTitleEdit = 'Editando lista';
    protected $_usarListaPaginada = true;
    protected $_modelClass = 'Curriculos_Model_DbTable_Listas';
    protected $_formClass = 'Curriculos_Form_Lista';
    protected $_formFilterClass = 'Curriculos_Form_FiltroListas';
    // Utilizado para o desmembramento das informações do post no momento da gravação do form
    protected $_curriculos = array();
    protected $_curriculos_para_remover = null;

    protected function afterFind(&$values)
    {
        $values['data_abertura'] = $this->_record->fmt_data_abertura();
        $values['data_fechamento'] = $this->_record->fmt_data_fechamento();

        if (isset($values['cargo_id']) && (int) $values['cargo_id'] > 0) {
            $cargosModel = new Curriculos_Model_DbTable_Cargos;
            $cargo = $cargosModel->find($values['cargo_id'])->current();
            $values['area_id'] = $cargo->area_id;
        }
    }

    protected function beforeSave(&$values)
    {
        if (isset($values['curriculos_para_remover'])) {
            $this->_curriculos_para_remover = explode(' ', trim($values['curriculos_para_remover']));
            unset($values['curriculos_para_remover']);
        }
        if (isset($values['area_id'])) {
            unset($values['area_id']);
        }
        if (!$values['cargo_id']) {
            $values['cargo_id'] = null;
        }
    }

    protected function afterSave(&$values)
    {
        $curriculos = $this->_getParam('curriculos', array());
        $listasCurriculosTable = new Curriculos_Model_DbTable_ListasCurriculos();
        // ----------------------------------------------------------------------------------------
        // Processa os currículos inseridos na lista
        // ----------------------------------------------------------------------------------------
        // salva o relacionamento com os currículos
        if (is_array($curriculos)) {
            foreach ($curriculos as $curriculo) {
                $curriculo['lista_id'] = $values['id'];
                $listasCurriculosTable->save($curriculo);
            }
        }
        // ----------------------------------------------------------------------------------------
        // Processa os currículos removidos da lista
        // ----------------------------------------------------------------------------------------
        // Processa os telefones removidos
        foreach ($this->_curriculos_para_remover as $lc_id) {
            if (is_numeric($lc_id)) {
                $listasCurriculosTable->remove($lc_id);
            }
        }
    }

    protected function beforeDelete($id)
    {
        $listasCurriculosModel = new Curriculos_Model_DbTable_ListasCurriculos();
        $listasCurriculosModel->removePorLista($id);
    }

}