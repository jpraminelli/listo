<?php

class Curriculos_Model_DbRow_Telefone extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composi��o" de toda a informa��o em forma de texto cadastrada para o telefone.
     * Ser� utilizado para indexa��o pelo Sphinx.
     */
    public function getPalavras()
    {
        return $this->numero;
    }

}
