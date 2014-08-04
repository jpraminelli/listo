<?php

class Curriculos_AdminCargosController extends Lib_Controller_Crud
{

    protected $_indexUrl = 'curriculos/admin-cargos';
    protected $_indexActionTitle = 'Administração de cargos';
    protected $_formActionTitleNew = 'Novo cargo';
    protected $_formActionTitleEdit = 'Editando cargo';
    protected $_modelClass = 'Curriculos_Model_DbTable_Cargos';
    protected $_formClass = 'Curriculos_Form_Cargo';
    protected $_formFilterClass = 'Curriculos_Form_FiltroCargos';

    protected function beforeDelete($id)
    {
        $cargosCurriculosModel = new Curriculos_Model_DbTable_CargosCurriculos;
        $cargosCurriculosModel->delete('cargo_id = ' . (int) $id);
    }

    public function ajaxCargosPorAreasAction()
    {
        $this->getHelper('Layout')->disableLayout(true);
        $this->getHelper('ViewRenderer')->setNoRender(true);

        $area_id = (int) $this->_getParam('area_id', 0);

        $fetch = Curriculos_Model_DbTable_Cargos::getFetchPairs(array('id', 'nome'), array('area_id = ' . (int) $area_id), 'nome ASC');
        $response = array();

        if (count($fetch) > 0) {
            $response['flag'] = true;
            $response['rowset'] = $fetch;
        } else {
            $response['flag'] = false;
        }

        die(Lib_Json::encode($response));
    }

    public function listaComboCargosAction()
    {
        $area_id = (int) $this->getRequest()->getParam('area');
        $cargosTable = new Curriculos_Model_DbTable_Cargos();
        $lista = $cargosTable->listaCombo($area_id);
        // Garante que a ordem dos itens será mantida em browsers como Chrome ou Opera,
        // utilizando um indice incremental.
        $cargos = array();
        $i = 1;
        foreach ($lista as $id => $item) {
            $cargos[$i] = array('id' => $id, 'nome' => $item);
            $i++;
        }
        //
        die(Lib_Json::encode($cargos));
    }

}