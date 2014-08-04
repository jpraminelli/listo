<?php

class Galerias_Model_DbTable_Imagens extends Lib_Db_Table_Abstract
{

    protected $_name = 'galerias_imagens';
    protected $_rowClass = 'Galerias_Model_DbRow_Imagem';
    protected $_referenceMap = array(
        'Galerias' => array(
            'refColumns' => 'id',
            'refTableClass' => 'Galerias_Model_DbTable_Galerias',
            'columns' => 'galerias_id',
        )
    );

}