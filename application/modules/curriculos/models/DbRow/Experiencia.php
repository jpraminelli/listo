<?php

class Curriculos_Model_DbRow_Experiencia extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composi��o" de toda a informa��o em forma de texto cadastrada para a experi�ncia.
     * Ser� utilizado para indexa��o pelo Sphinx.
     */
    public function getPalavras()
    {
        $palavras = array(
            $this->empresa,
            $this->cargo,
            $this->resumo_atividades,
            $this->tempo_trabalho,
            $this->contato_pessoa
        );
        return implode(' ', $palavras);
    }

}
