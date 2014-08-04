<?php

class Curriculos_Model_DbRow_Area extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composição" de toda a informação em forma de texto cadastrada para a área.
     * Será utilizado para indexação pelo Sphinx.
     */
    public function getPalavras()
    {
        $string = "$this->nome ";
        $string .= "___area_id___{$this->id}___";
        return $string;
    }

}
