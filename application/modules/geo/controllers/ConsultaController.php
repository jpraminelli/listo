<?php

class Geo_ConsultaController extends Zend_Controller_Action
{

    public function listaComboCidadesAction()
    {
        $uf = $this->getRequest()->getParam('uf');
        $cidadesTable = new Geo_Model_DbTable_Cidades();
        $lista = $cidadesTable->listaCombo($uf);
        // Garante que a ordem dos itens será mantida em browsers como Chrome ou Opera,
        // utilizando um indice incremental.
        $cidades = array();
        $i = 1;
        foreach ($lista as $id => $item) {
            $cidades[$i] = array('id' => $id, 'nome' => $item);
            $i++;
        }
        //
        die(Lib_Json::encode($cidades));
    }

    public function jsonCidadesAction()
    {
        $uf = substr($this->_getParam('uf'), 0, 2);

        $rowset = Geo_Model_DbTable_Cidades::getFetchPairs(array('id', 'nome'), "uf = '{$uf}'", array('capital DESC', 'nome ASC'));

        if (count($rowset) > 0) {
            $response = array(
                'flag' => true,
                'rowset' => array()
            );

            foreach ($rowset as $k => $v) {
                $response['rowset'][] = array(
                    'id' => $k,
                    'nome' => $v
                );
            }
        } else {
            $response = array(
                'flag' => false,
                'rowset' => array()
            );
        }

        die(Lib_Json::encode($response));
    }

}
