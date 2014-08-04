<?php

abstract class Lib_Form extends Zend_Form
{

    protected $_data = null;
    protected $_record = null;
    protected $_backUrl = null;

    public function __construct($data = null, $record = null, $backUrl = null, $options = null)
    {
        $this->_data = $data;
        $this->_record = $record;
        $this->_backUrl = $backUrl;
        parent::__construct($options);
        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
    }

    public function addHr($id = null)
    {
        if (!$id) {
            $id = 'hr_' . uniqid();
        }
        $hr = new Lib_Form_Element_Html($id);
        $hr->setValue('<hr />');
        $hr->removeDecorator('Label');
        $hr->setIgnore(true);
        $this->addElement($hr);
    }

    public function addButtons() //($url = null)
    {
        /*
         * Submit
         */
        $salvar = $this->createElement('submit', 'Salvar');
        $salvar->setIgnore(true)
            ->setAttrib('class', 'btn btn-primary');
        $this->addElement($salvar);

        /*
         * Cancelar
         */
        $cancelar = $this->createElement('button', 'Cancelar');
        $cancelar->setIgnore(true);
        $cancelar->setAttrib('class', 'btn');
        if ($this->_backUrl) {
            $cancelar->setAttrib('onclick', "location.href='{$this->_backUrl}'");
        }
        $this->addElement($cancelar);

        return $this;
    }

}
