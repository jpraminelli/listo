<?php

class Curriculos_Model_DbTable_Areas extends Lib_Db_Table_Abstract
{

    protected $_name = 'areas';
    protected $_rowClass = 'Curriculos_Model_DbRow_Area';

    protected function getSelect(array $filtros = array())
    {
        $select = $this->select();
        $select->from(array('a' => $this->_name), array('*', 'curriculos_qtde' => new Zend_Db_Expr('(SELECT COUNT(cc.id) FROM cargos_curriculos cc INNER JOIN cargos c ON c.id = cc.cargo_id WHERE c.area_id = a.id)')))
//        $select->from(array('a' => $this->_name), array('*', 'curriculos_qtde' => new Zend_Db_Expr('(SELECT COUNT(cc.id) FROM cargos_curriculos cc INNER JOIN cargos c ON c.id = cc.cargo_id WHERE c.area_id = a.id)')))
            ->order('nome ASC');

        return $select;
    }

    public function listaCombo($defaultText = 'Selecione...')
    {
        $lista = array('' => $defaultText);

        $select = $this->select();
        $select->where('ativa IS TRUE')
                ->order('nome');

        $listaDb = $this->fetchAll($select);
        foreach ($listaDb as $item) {
            $lista[$item->id] = $item->nome;
        }
        return $lista;
    }

}
