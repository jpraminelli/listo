<?php

class Curriculos_AdminAreasController extends Lib_Controller_Crud
{

    protected $_indexUrl = 'curriculos/admin-areas';
    protected $_indexActionTitle = 'Administra��o de �reas';
    protected $_formActionTitleNew = 'Nova �rea';
    protected $_formActionTitleEdit = 'Editando �rea';
    protected $_listaPaginada = false;
    protected $_modelClass = 'Curriculos_Model_DbTable_Areas';
    protected $_formClass = 'Curriculos_Form_Area';

    protected function beforeDelete($id)
    {
        $cargosModel = new Curriculos_Model_DbTable_Cargos;
        $cargosCurriculosModel = new Curriculos_Model_DbTable_CargosCurriculos;

        foreach ($cargosModel->fetchAll('area_id = ' . (int) $id) as $cargo) {
            $cargosCurriculosModel->delete('cargo_id = ' . (int) $cargo->id);
            $cargo->delete();
        }
    }

}