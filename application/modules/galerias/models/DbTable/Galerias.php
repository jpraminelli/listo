<?php

class Galerias_Model_DbTable_Galerias extends Lib_Db_Table_Abstract
{

    protected $_name = 'galerias';
    protected $_rowClass = 'Galerias_Model_DbRow_Galeria';
    protected $_dependentTables = array(
        'Galerias_Model_DbTable_Imagens'
    );

    protected function getSelect(array $filtros = array())
    {
        $select = $this->select();
        $select->from(array('g' => $this->_name))
                ->order('data DESC');

        if (isset($filtros['buscar']) && $filtros['buscar'] != '') {
            $select->where('(TO_ASCII(titulo) ILIKE TO_ASCII(?)', '%' . $filtros['buscar'] . '%')
                    ->orWhere('TO_ASCII(titulo) ILIKE TO_ASCII(?))', '%' . $filtros['buscar'] . '%');
        }

        if(isset($filtros['status']) && $filtros['status'] != 'todos') {
            $select->where('g.ativo = ?', $filtros['status']);
        } else if(!isset($filtros['status'])) {
            $select->where('g.ativo IS TRUE');
        }

        return $select;
    }

}