<?php

class Curriculos_Model_DbTable_Cargos extends Lib_Db_Table_Abstract
{

    protected $_name = 'cargos';
    protected $_rowClass = 'Curriculos_Model_DbRow_Cargo';

    protected function getSelect(array $filtros = array())
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
            ->from(array('c' => $this->_name), array('*', 'curriculos_qtde' => new Zend_Db_Expr('COUNT(cc.id)')))
            ->join(array('a' => 'areas'), 'a.id = c.area_id', array('area_nome' => 'nome'))
            ->joinLeft(array('cc' => 'cargos_curriculos'), 'c.id = cc.cargo_id', array())
            ->group(array(
                'c.id',
                'c.area_id',
                'c.nome',
                'c.ativo',
                'a.nome'
            ))
            ->order('nome ASC');

        if (isset($filtros['status']) && $filtros['status'] != 'todos') {
            $select->where('c.ativo = ?', $filtros['status']);
        }

        if (isset($filtros['area']) && (int) $filtros['area'] > 0) {
            $select->where('c.area_id = ?', (int) $filtros['area']);
        }

        if (isset($filtros['buscar']) && strlen($filtros['buscar']) > 0) {
            $select->where('c.nome ILIKE(?)', '%' . $filtros['buscar'] . '%');
        }

        return $select;
    }

    public function listaCombo($area_id, $defaultText = 'Selecione...')
    {
        if (!is_numeric($area_id)) {
            return array();
        }
        $lista = array('' => $defaultText);

        $select = $this->select();
        $select->where('ativo IS TRUE')
                ->where('area_id = ?', $area_id)
                ->order('nome');

        $listaDb = $this->fetchAll($select);
        foreach ($listaDb as $item) {
            $lista[$item->id] = $item->nome;
        }
        return $lista;
    }

    /**
     * Retorna o ID da área de um determinado cargo.
     * 
     * @param int $cargo_id 
     */
    public function getArea($cargo_id)
    {
        $cargo = $this->find($cargo_id)->current();
        if ($cargo) {
            return $cargo->area_id;
        } else {
            return null;
        }
    }

    public function listaPorCurriculoVisualizacao($curriculo_id)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array('c' => 'cargos'), array('cargo_nome' => 'nome'))
                ->join(array('a' => 'areas'), 'a.id = c.area_id', array('area_nome' => 'nome'))
                ->join(array('cc' => 'cargos_curriculos'), 'cc.cargo_id = c.id')
                ->where('cc.curriculo_id = ?', (int) $curriculo_id)
                ->order('cc.id');

        return $this->fetchAll($select);
    }

}
