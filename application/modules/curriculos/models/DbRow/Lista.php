<?php

class Curriculos_Model_DbRow_Lista extends Zend_Db_Table_Row_Abstract
{

    public function fmt_data_abertura()
    {
        if ($this->data_abertura) {
            $data = new Zend_Date($this->data_abertura);
            return substr($data, 0, 10);
        }
        return '';
    }

    public function fmt_data_fechamento()
    {
        if ($this->data_fechamento) {
            $data = new Zend_Date($this->data_fechamento);
            return substr($data, 0, 10);
        }
        return '';
    }

    public function fmt_area_cargo()
    {
        $retorno = array();
        if ($this->area) {
            $retorno[] = $this->area;
        }
        if ($this->cargo) {
            $retorno[] = $this->cargo;
        }
        return implode(' :: ', $retorno);
    }

    /**
     * De acordo com as datas de abertura, fechamento e também a data atual, determina se a lista é considerada vigente.
     * 
     * @return bool
     */
    public function isVigente()
    {
        if (!$this->data_abertura) {
            return false;
        }
        $abertura = (int) str_replace('-', '', $this->data_abertura);
        if ($this->data_fechamento) {
            $fechamento = (int) str_replace('-', '', $this->data_fechamento);
        } else {
            $fechamento = 99999999;
        }
        $hoje = (int) date('Ymd');
        return ($hoje >= $abertura) && ($hoje <= $fechamento);
    }

}
