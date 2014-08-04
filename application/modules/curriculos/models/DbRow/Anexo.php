<?php

class Curriculos_Model_DbRow_Anexo extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composi��o" de toda a informa��o em forma de texto cadastrada para o anexo (incluindo seu conte�do).
     * Ser� utilizado para indexa��o pelo Sphinx.
     */
    public function getPalavras()
    {
        $filename = DIR_ANEXOS . '/' . $this->id;
        if (!file_exists($filename)) {
            return '';
        }
        $extrator = new Lib_Extrator();
        return $this->descricao . ' ' . $this->nome_original . ' ' . utf8_decode($extrator->extracttext($filename));
    }

}
