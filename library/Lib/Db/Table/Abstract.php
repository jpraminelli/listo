<?php

abstract class Lib_Db_Table_Abstract extends Zend_Db_Table_Abstract
{

    protected $_perPage = 15;
    protected $_pageRange = 5;

    public function lista(array $filtros = array())
    {
        $select = $this->getSelect($filtros);

        return $this->fetchAll($select);
    }

    public function listaPaginada(array $filtros = array())
    {
        $select = $this->getSelect($filtros);

        return $this->_paginator($select);
    }

    protected function getSelect(array $filtros = array())
    {
        return $this->select();
    }

    protected function _paginator(Zend_Db_Table_Select $select = null)
    {
        if (null === $select) {
            $select = $this->select();
        }

        return Zend_Paginator::factory($select);
    }

    public static function getFetchPairs($fields = '*', $where = array(), $order = array())
    {
        $table = get_called_class();
        $table = new $table();

        $select = $table->select();
        $select->from($table->_name, $fields);

        if (is_array($where)) {
            foreach ($where as $value) {
                $select->where($value);
            }
        } elseif (is_string($where)) {
            $select->where($where);
        }

        if (is_array($order)) {
            foreach ($order as $value) {
                $select->order($value);
            }
        } elseif (is_string($order)) {
            $select->order($order);
        }

        return $table->getAdapter()->fetchPairs($select);
    }

    public static function staticFind($id)
    {
        $table = get_called_class();
        $table = new $table();

        return $table->find($id)->current();
    }

}