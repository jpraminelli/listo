<?php

class Curriculos_Model_DbRow_Cargo extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composição" de toda a informação em forma de texto cadastrada para o cargo.
     * Será utilizado para indexação pelo Sphinx.
     */
    public function getPalavras()
    {
        $string = "$this->nome ";
        $string .= "___cargo_id___{$this->id}___";
        return $string;
    }

}
