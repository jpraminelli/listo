<?php

class Curriculos_Model_DbTable_CargosCurriculos extends Lib_Db_Table_Abstract
{

    protected $_name = 'cargos_curriculos';
    protected $_rowClass = 'Curriculos_Model_DbRow_CargoCurriculo';

    public function listaPorCurriculo($curriculo_id)
    {
        return $this->fetchAll($this->select()->where('curriculo_id = ?', $curriculo_id)->order('id')); // usa a ordem de inserção
    }

    /**
     * Retorna uma lista no formato (área :: cargo) de todos os cargos relacionados ao currículo.
     * 
     * @param type $curriculo_id Id do currículo.
     * 
     * @return array Lista de cargos.
     */
    public function arrayPorCurriculo($curriculo_id)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array('cc' => $this->_name), null);
        $select->join(array('ca' => 'cargos'), 'ca.id = cc.cargo_id', array('cargo' => 'nome'));
        $select->join(array('ar' => 'areas'), 'ar.id = ca.area_id', array('area' => 'nome'));
        $select->where('curriculo_id = ?', $curriculo_id);
        $resultado = array();
        $cargosCurriculos = $this->fetchAll($select);
        foreach ($cargosCurriculos as $cargoCurriculo) {
            $resultado[] = "$cargoCurriculo->area :: $cargoCurriculo->cargo";
        }
        return $resultado;
    }

    public function save(array $values)
    {
        if (!is_array($values)) {
            return;
        }
        $id = isset($values['id']) && (int) $values['id'] ? (int) $values['id'] : 0;
        $cargoCurriculo = null;
        if ($id) {
            $cargoCurriculo = $this->find($id)->current();
        } else {
            unset($values['id']);
        }
        if (!$cargoCurriculo) {
            $cargoCurriculo = $this->createRow();
            $cargoCurriculo->curriculo_id = $values['curriculo_id'];
        }
        $cargoCurriculo->cargo_id = $values['cargo_id'];
        return $cargoCurriculo->save();
    }

    public function remove($id)
    {
        if (!is_numeric($id)) {
            return 0;
        }
        return $this->delete("id = $id");
    }

}
