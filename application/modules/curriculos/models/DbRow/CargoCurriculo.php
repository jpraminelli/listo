<?php

class Curriculos_Model_DbRow_CargoCurriculo extends Zend_Db_Table_Row_Abstract
{

    /**
     * Retorna uma "composi��o" de toda a informa��o em forma de texto cadastrada para o cargo.
     * Ser� utilizado para indexa��o pelo Sphinx.
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
