<?php

class Curriculos_Model_DbTable_Experiencias extends Lib_Db_Table_Abstract
{

    protected $_name = 'experiencias';
    protected $_rowClass = 'Curriculos_Model_DbRow_Experiencia';

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
        $experiencia = null;
        if ($id) {
            $experiencia = $this->find($id)->current();
        } else {
            unset($values['id']);
        }
        if (!$experiencia) {
            $experiencia = $this->createRow();
            $experiencia->curriculo_id = $values['curriculo_id'];
        }
        $experiencia->empresa = $values['empresa'];
        $experiencia->cargo = $values['cargo'];
        $experiencia->resumo_atividades = $values['resumo_atividades'];
        $experiencia->tempo_trabalho = $values['tempo_trabalho'];
        $experiencia->contato_pessoa = $values['contato_pessoa'];
        $experiencia->contato_telefone = $values['contato_telefone'];
        return $experiencia->save();
    }

    public function remove($id)
    {
        if (!is_numeric($id)) {
            return 0;
        }
        return $this->delete("id = $id");
    }

}
