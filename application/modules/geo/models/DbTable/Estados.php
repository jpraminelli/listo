<?php

class Geo_Model_DbTable_Estados extends Lib_Db_Table_Abstract
{

    protected $_name = 'estados';
    protected $_primary = 'uf';

    public function listaCombo($defaultText = 'Selecione...')
    {
        $lista = array('' => $defaultText);
        $listaDb = $this->fetchAll($this->select()->order('nome'));
        foreach ($listaDb as $item) {
            $lista[$item->uf] = $item->nome;
        }
        return $lista;
    }

}
