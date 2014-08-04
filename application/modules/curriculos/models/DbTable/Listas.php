<?php

class Curriculos_Model_DbTable_Listas extends Lib_Db_Table_Abstract
{

    protected $_name = 'listas';
    protected $_rowClass = 'Curriculos_Model_DbRow_Lista';

    protected function getSelect(array $filtros = array())
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array('l' => $this->_name))
                ->joinLeft(array('ca' => 'cargos'), 'ca.id = l.cargo_id', array('cargo' => 'nome'))
                ->joinLeft(array('ar' => 'areas'), 'ar.id = ca.area_id', array('area' => 'nome'))
                ->order('data_fechamento desc');

        if (isset($filtros['data']) && !empty($filtros['data']) && Zend_Date::isDate($filtros['data'], 'dd/MM/YYYY')) {
            $data = new Zend_Date($filtros['data'], null, 'pt_BR');
            $select->where('data_abertura::date <= ?::date', $data->get('YYYY-MM-dd'))
                    ->where('(data_fechamento::date >= ?::date or data_fechamento is null)', $data->get('YYYY-MM-dd'));
        }

        if (isset($filtros['buscar']) && !empty($filtros['buscar'])) {
            $select->where('(to_ascii(l.nome) ILIKE to_ascii(?)', '%' . $filtros['buscar'] . '%')
                ->orWhere('to_ascii(ca.nome) ILIKE to_ascii(?)', '%' . $filtros['buscar'] . '%')
                ->orWhere('to_ascii(ar.nome) ILIKE to_ascii(?))', '%' . $filtros['buscar'] . '%');
        }

        return $select;
    }

}
