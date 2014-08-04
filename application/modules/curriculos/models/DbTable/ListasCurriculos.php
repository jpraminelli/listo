<?php

class Curriculos_Model_DbTable_ListasCurriculos extends Lib_Db_Table_Abstract
{

    protected $_name = 'listas_curriculos';

    public function listaPorLista($lista_id)
    {
        if (!is_numeric($lista_id)) {
            return null;
        }
        $this->_rowClass = 'Curriculos_Model_DbRow_Curriculo';
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array('lc' => $this->_name), array('lc_id' => 'lc.id'));
        $select->join(array('c' => 'curriculos'), 'c.id = lc.curriculo_id');
        $select->where('lc.lista_id = ?', $lista_id)->order('c.pontuacao desc');
        return $this->fetchAll($select);
    }

    public function save(array $values)
    {
        if (!is_array($values)) {
            return;
        }
        $id = isset($values['id']) && (int) $values['id'] ? (int) $values['id'] : 0;
        $listaCurriculo = null;
        if ($id) {
            $listaCurriculo = $this->find($id)->current();
        } else {
            unset($values['id']);
        }
        if (!$listaCurriculo) {
            $listaCurriculo = $this->createRow();
            $listaCurriculo->lista_id = $values['lista_id'];
            $listaCurriculo->curriculo_id = $values['curriculo_id'];
        }
        return $listaCurriculo->save();
    }

    public function remove($id)
    {
        if (!is_numeric($id)) {
            return 0;
        }
        return $this->delete("id = $id");
    }

    public function removePorLista($lista_id)
    {
        if (!is_numeric($lista_id)) {
            return 0;
        }
        return $this->delete("lista_id = $lista_id");
    }

}
