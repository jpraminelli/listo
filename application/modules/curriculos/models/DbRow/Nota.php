<?php

class Curriculos_Model_DbRow_Nota extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composi��o" de toda a informa��o em forma de texto cadastrada para a nota.
     * Ser� utilizado para indexa��o pelo Sphinx.
     */
    public function getPalavras()
    {
        return $this->texto;
    }

}
