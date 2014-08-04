<?php

class Curriculos_Model_DbTable_CurriculosCursos extends Zend_Db_Table_Abstract
{

    protected $_name = 'curriculos_cursos';

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
        $curso = null;
        if ($id) {
            $curso = $this->find($id)->current();
        } else {
            unset($values['id']);
        }
        if (!$curso) {
            $curso = $this->createRow();
            $curso->curriculo_id = $values['curriculo_id'];
        }
        $curso->instituicao = $values['instituicao'];
        $curso->duracao = $values['duracao'];
        $curso->curso = $values['curso'];

        return $curso->save();
    }

    public function remove($id)
    {
        if (!is_numeric($id)) {
            return 0;
        }
        return $this->delete("id = $id");
    }

}
