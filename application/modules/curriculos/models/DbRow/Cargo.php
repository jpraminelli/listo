<?php

class Curriculos_Model_DbRow_Cargo extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composi��o" de toda a informa��o em forma de texto cadastrada para o cargo.
     * Ser� utilizado para indexa��o pelo Sphinx.
     */
    public function getPalavras()
    {
        $string = "$this->nome ";
        $string .= "___cargo_id___{$this->id}___";
        return $string;
    }

}
