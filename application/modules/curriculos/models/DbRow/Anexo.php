<?php

class Curriculos_Model_DbRow_Anexo extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composição" de toda a informação em forma de texto cadastrada para o anexo (incluindo seu conteúdo).
     * Será utilizado para indexação pelo Sphinx.
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
