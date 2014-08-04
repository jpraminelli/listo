<?php

class Curriculos_Model_DbRow_CargoCurriculo extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composição" de toda a informação em forma de texto cadastrada para o cargo.
     * Será utilizado para indexação pelo Sphinx.
     */
    public function getPalavras()
    {
        $cargoTable = new Curriculos_Model_DbTable_Cargos();
        $cargo = $cargoTable->find($this->cargo_id)->current();
        if (!$cargo) {
            return '';
        }
        $areasTable = new Curriculos_Model_DbTable_Areas();
        $area = $areasTable->find($cargo->area_id)->current();
        if ($area) {
            return $area->getPalavras() . ' ' . $cargo->getPalavras();
        } else {
            return $cargo->getPalavras();
        }
    }

}
