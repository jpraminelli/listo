<?php

class Curriculos_Model_DbRow_Area extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composi��o" de toda a informa��o em forma de texto cadastrada para a �rea.
     * Ser� utilizado para indexa��o pelo Sphinx.
     */
    public function getPalavras()
    {
        $string = "$this->nome ";
        $string .= "___area_id___{$this->id}___";
        return $string;
    }

}
