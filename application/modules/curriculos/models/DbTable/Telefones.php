<?php

class Curriculos_Model_DbTable_Telefones extends Lib_Db_Table_Abstract
{

    protected $_name = 'telefones';
    protected $_rowClass = 'Curriculos_Model_DbRow_Telefone';

    public function listaPorCurriculo($curriculo_id)
    {
        return $this->fetchAll($this->select()->where('curriculo_id = ?', $curriculo_id)->order('id'));
    }

    public function save(array $values)
    {
        if (!is_array($values)) {
            return;
        }
        $id = isset($values['id']) && (int) $values['id'] ? (int) $values['id'] : 0;
        $telefone = null;
        if ($id) {
            $telefone = $this->find($id)->current();
        } else {
            unset($values['id']);
        }
        if (!$telefone) {
            $telefone = $this->createRow();
            $telefone->curriculo_id = $values['curriculo_id'];
        }
        $telefone->numero = $values['numero'];
        return $telefone->save();
    }

    public function remove($id)
    {
        if (!is_numeric($id)) {
            return 0;
        }
        return $this->delete("id = $id");
    }

}
