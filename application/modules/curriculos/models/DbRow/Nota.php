<?php

class Curriculos_Model_DbRow_Nota extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composição" de toda a informação em forma de texto cadastrada para a nota.
     * Será utilizado para indexação pelo Sphinx.
     */
    public function getPalavras()
    {
        return $this->texto;
    }

}
