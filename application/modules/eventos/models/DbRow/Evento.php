<?php

class Eventos_Model_DbRow_Evento extends Zend_Db_Table_Row_Abstract
{

    public function fmt_data($format = Zend_Date::DATE_MEDIUM)
    {
        if (isset($this->data)) {
            $date = new Zend_Date($this->data);
            return $date->get($format);
        }
    }

}