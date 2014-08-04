<?php

class Galerias_Model_DbRow_Galeria extends Zend_Db_Table_Row_Abstract
{

    public function fmt_data($format = Zend_Date::DATE_MEDIUM)
    {
        if (isset($this->data)) {
            $date = new Zend_Date($this->data);
            return $date->get($format);
        }
    }

    public function imagens()
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array('i' => 'galerias_imagens'))
                ->where('galerias_id = ?', (int) $this->id)
                ->order('id ASC');

        return $this->getTable()->fetchAll($select);
    }

    public function principal()
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array('i' => 'galerias_imagens'))
                ->where('galerias_id = ?', (int) $this->id)
                ->order('principal DESC');

        return $this->getTable()->fetchRow($select);
    }

}