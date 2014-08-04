<?php

class Eventos_Model_DbTable_Eventos extends Lib_Db_Table_Abstract
{

    protected $_name = 'eventos';
    protected $_rowClass = 'Eventos_Model_DbRow_Evento';

    protected function getSelect(array $filtros = array())
    {
        $select = $this->select();
        $select->from(array('e' => $this->_name))
                ->order('data DESC');

        if (isset($filtros['buscar']) && $filtros['buscar'] != '') {
            $select->where('(TO_ASCII(nome) ILIKE TO_ASCII(?)', '%' . $filtros['buscar'] . '%')
                    ->orWhere('TO_ASCII(nome) ILIKE TO_ASCII(?))', '%' . $filtros['buscar'] . '%');
        }

        if(isset($filtros['status']) && $filtros['status'] != 'todos') {
            $select->where('e.ativo = ?', $filtros['status']);
        } else if(!isset($filtros['status'])) {
            $select->where('e.ativo IS TRUE');
        }

        return $select;
    }

}