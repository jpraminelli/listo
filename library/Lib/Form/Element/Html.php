<?php

class Lib_Form_Element_Html extends Zend_Form_Element_Xhtml
{

    public $helper = 'formNote';

    public function __construct($spec, $options = null)
    {
        parent::__construct($spec, $options);
    }

}
