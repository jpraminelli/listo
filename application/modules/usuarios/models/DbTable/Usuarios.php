<?php

class Usuarios_Model_DbTable_Usuarios extends Lib_Db_Table_Abstract
{

    protected $_name = 'usuarios';
    protected $_rowClass = 'Usuarios_Model_DbRow_Usuario';

    protected function getSelect(array $filtros = array())
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array('u' => $this->_name))
                ->order('nome ASC');

        if (isset($filtros['status']) && $filtros['status'] != '') {
            $select->where('u.ativo::text = ?', $filtros['status']);
        }
        
        if (isset($filtros['tipo']) && $filtros['tipo'] != '') {
            $select->where('u.tipo = ?', $filtros['tipo']);
        }

        if (isset($filtros['buscar']) && strlen($filtros['buscar']) > 0) {
            $select->where('(u.nome ILIKE(?)', '%' . $filtros['buscar'] . '%')
                    ->orWhere('u.email ILIKE(?))', '%' . $filtros['buscar'] . '%');
        }

        return $select;
    }

}
