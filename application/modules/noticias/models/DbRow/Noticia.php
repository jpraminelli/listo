<?php

class Noticias_Model_DbRow_Noticia extends Zend_Db_Table_Row_Abstract
{

    public function fmt_dh_cadastro($format = Zend_Date::DATETIME_MEDIUM)
    {
        if (isset($this->dh_cadastro)) {
            $date = new Zend_Date($this->dh_cadastro);
            return $date->get($format);
        }
    }

}