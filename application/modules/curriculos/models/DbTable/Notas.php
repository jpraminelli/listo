<?php

class Curriculos_Model_DbTable_Notas extends Lib_Db_Table_Abstract
{

    protected $_name = 'notas';
    protected $_rowClass = 'Curriculos_Model_DbRow_Nota';

    /**
     * Adiciona uma log tipo=S na tabela de notas.
     * 
     * @param int $curriculo_id O id do currículo.
     * @param string $texto A mensagem de log.
     */
    public function adicionarLogSistema($curriculo_id, $texto)
    {
        if (!is_numeric($curriculo_id) || (!$texto)) {
            return;
        }
        $tableCurriculos = new Curriculos_Model_DbTable_Curriculos();
        if (!$tableCurriculos->existeCurriculo($curriculo_id)) {
            return;
        }
        if (!is_numeric(USER_ID)) {
            return;
        }
        // salva a nota (log do tipo sistema)
        $nota = $this->createRow(
                array(
                    'curriculo_id' => $curriculo_id,
                    'usuario_id' => USER_ID,
                    'texto' => $texto,
                    'tipo' => 'S',
                )
        );
        $nota->save();
    }

    public function listaPorCurriculo($curriculo_id)
    {
        return $this->fetchAll($this->select()->where('curriculo_id = ?', $curriculo_id)->order('id'));
    }

    public function listaPorCurriculoVisualizacao($curriculo_id)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array('n' => $this->_name))
                ->join(array('u' => 'usuarios'), 'u.id = n.usuario_id', array('usuario_nome' => 'nome'))
                ->where('n.curriculo_id = ?', $curriculo_id)
                ->order('id');

        return $this->fetchAll($select);
    }

    public function save(array $values)
    {
        if (!is_array($values)) {
            return;
        }
        $id = isset($values['id']) && (int) $values['id'] ? (int) $values['id'] : 0;
        $nota = null;
        if ($id) {
            $nota = $this->find($id)->current();
        } else {
            unset($values['id']);
        }
        if (!$nota) {
            $nota = $this->createRow();
            $nota->curriculo_id = $values['curriculo_id'];
            $nota->usuario_id = USER_ID;
            $nota->tipo = 'U';
        }
        $nota->texto = $values['texto'];

        return $nota->save();
    }

    public function remove($id)
    {
        if (!is_numeric($id)) {
            return 0;
        }
        return $this->delete("id = $id");
    }

}
