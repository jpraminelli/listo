<?php

class Banners_Model_DbTable_Banners extends Lib_Db_Table_Abstract
{

    protected $_name = 'banners';
   

    protected function getSelect(array $filtros = array())
    {
        $select = $this->select();
        $select->from(array('n' => $this->_name))
                ->order('n.ordem ASC')
                ->order('n.nome ASC');

        if (isset($filtros['buscar']) && strlen($filtros['buscar']) > 0) {
            $select->where('TO_ASCII(n.nome) ILIKE TO_ASCII(?)', "%{$filtros['buscar']}%");
        }

       

        return $select;
    }

}