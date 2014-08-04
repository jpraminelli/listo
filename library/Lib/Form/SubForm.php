<?php

class Lib_Form_SubForm extends Zend_Form_SubForm
{

    protected $_data = null;
    protected $_record = null;

    public function __construct($data = null, $options = null)
    {
        $this->_data = $data;
        parent::__construct($options);
    }

    public function setRecord($record)
    {
        $this->_record = $record;
    }

}
