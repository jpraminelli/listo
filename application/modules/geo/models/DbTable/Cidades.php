<?php

class Geo_Model_DbTable_Cidades extends Lib_Db_Table_Abstract
{

    protected $_name = 'cidades';

    /**
     * Obtém informações completas sobre a cidade (incluíndo o nome do estado e a UF).
     * 
     * @param int $cidade_id 
     * @return array Informações sobre a cidade
     */
    public function getInfo($cidade_id)
    {
        if (!is_numeric($cidade_id)) {
            return array();
        }
        $cidade = $this->find($cidade_id)->current();
        if (!$cidade) {
            return array();
        }
        $info = array(
            'nome' => $cidade->nome,
            'capital' => $cidade->capital
        );
        $estadosTable = new Geo_Model_DbTable_Estados();
        $estado = $estadosTable->find($cidade->uf)->current();
        if ($estado) {
            $info['estado'] = $estado->nome;
            $info['uf'] = $estado->uf;
        }
        return $info;
    }

    public function getUf($cidade_id)
    {
        $cidade = $this->find($cidade_id)->current();
        if (!$cidade) {
            return '';
        } else {
            return $cidade->uf;
        }
    }

    public function listaCombo($uf, $defaultText = 'Selecione...')
    {
        $uf = strtoupper(trim($uf));
        if (strlen($uf) != 2) {
            return array();
        }
        $lista = array('' => $defaultText);
        $listaDb = $this->fetchAll($this->select()->where('uf = ?', $uf)->order(array('capital desc', 'nome')));
        foreach ($listaDb as $item) {
            $lista[$item->id] = $item->nome;
        }
        return $lista;
    }

}
