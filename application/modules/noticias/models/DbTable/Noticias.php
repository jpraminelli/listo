<?php

class Noticias_Model_DbTable_Noticias extends Lib_Db_Table_Abstract
{

    protected $_name = 'noticias';
    protected $_rowClass = 'Noticias_Model_DbRow_Noticia';

    protected function getSelect(array $filtros = array())
    {
        $select = $this->select();
        $select->from(array('n' => $this->_name))
                ->order('n.dh_cadastro DESC');

        if (isset($filtros['buscar']) && strlen($filtros['buscar']) > 0) {
            $select->where('(TO_ASCII(n.titulo) ILIKE TO_ASCII(?)', "%{$filtros['buscar']}%")
                    ->orWhere('TO_ASCII(n.texto) ILIKE TO_ASCII(?))', "%{$filtros['buscar']}%");
        }

        if (isset($filtros['status']) && $filtros['status'] != 'todos') {
            $select->where('n.ativo::text = ?', $filtros['status']);
        } elseif(!isset($filtros['status'])) {
            $select->where('n.ativo IS TRUE');
        }

        return $select;
    }

}