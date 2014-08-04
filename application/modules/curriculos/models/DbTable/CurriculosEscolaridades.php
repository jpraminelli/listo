<?php

class Curriculos_Model_DbTable_CurriculosEscolaridades extends Zend_Db_Table_Abstract
{

    protected $_name = 'curriculos_escolaridades';

    public function listaPorCurriculo($curriculo_id)
    {
        return $this->fetchAll($this->select()->where('curriculo_id = ?', $curriculo_id)->order('id'));
    }

    public function listaPorCurriculoVisualizacao($curriculo_id)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array('ce' => $this->_name))
                ->join(array('et' => 'escolaridades_tipos'), 'et.id = ce.escolaridade_tipo_id', array('escolaridade_tipo_nome' => 'nome'))
                ->where('curriculo_id = ?', (int) $curriculo_id)
                ->order('id');

        return $this->fetchAll($select);
    }

    public function save(array $values)
    {
        if (!is_array($values)) {
            return;
        }
        $id = isset($values['id']) && (int) $values['id'] ? (int) $values['id'] : 0;
        $escolaridade = null;
        if ($id) {
            $escolaridade = $this->find($id)->current();
        } else {
            unset($values['id']);
        }
        if (!$escolaridade) {
            $escolaridade = $this->createRow();
            $escolaridade->curriculo_id = $values['curriculo_id'];
        }
        $escolaridade->instituicao = $values['instituicao'];
        $escolaridade->duracao = $values['duracao'];
        $escolaridade->curso = $values['curso'];
        $escolaridade->escolaridade_tipo_id = $values['escolaridade_tipo_id'];

        return $escolaridade->save();
    }

    public function remove($id)
    {
        if (!is_numeric($id)) {
            return 0;
        }
        return $this->delete("id = $id");
    }

}
