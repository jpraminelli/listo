<?php

class Curriculos_Library_SearchResultsPaginator implements Zend_Paginator_Adapter_Interface
{

    private $_curriculosTable = null;
    private $_ids = null;
    private $_count = 0;

    public function __construct(Curriculos_Model_DbTable_Curriculos $curriculosTable)
    {
        $this->_curriculosTable = $curriculosTable;
        $session = Lib_Session_Namespace::instance();
        $this->_ids = (isset($session->searchInfo->ids)) ? $session->searchInfo->ids : array();
        $this->_count = count($this->_ids);
    }

    public function getItems($offset, $itemCountPerPage)
    {
        $listaIds = array();
        for ($i = $offset; $i < $offset + $itemCountPerPage; $i++) {
            if (isset($this->_ids[$i])) {
                $listaIds[] = $this->_ids[$i];
            }
        }
        if (count($listaIds)) {
            return $this->_curriculosTable->listaParaBusca($listaIds);
        } else {
            return array();
        }
    }

    public function count()
    {
        return $this->_count;
    }

}
