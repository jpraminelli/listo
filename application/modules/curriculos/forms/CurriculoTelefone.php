<?php

class Curriculos_Form_CurriculoTelefone extends Lib_Form_SubForm {

    public function init()
    {
        if ($this->_data && isset($this->_data['id'])) {
            $recid = $this->_data['id'];
        } else {
            $recid = 'new_' . time();
        }
        
        $this->setName("telefones_$recid");
        $this->setElementsBelongTo("telefones[$recid]");

        // ------------------------------------------------------------------------------------------------------------
        // id (hidden)
        // ------------------------------------------------------------------------------------------------------------
        $id = $this->createElement('hidden', 'id');
        $id->removeDecorator('label');
        $id->setValue($recid);
        $this->addElement($id);

        // ------------------------------------------------------------------------------------------------------------
        // telefone
        // ------------------------------------------------------------------------------------------------------------
        $telefone = $this->createElement('text', 'numero');
        $telefone->setLabel('Telefone');
        $telefone->setAttrib('class', 'span2 telefone');
        $telefone->setAttrib('maxlength', '50');
        $telefone->setRequired(true);
        $telefone->addFilters(array('StringTrim', 'StripTags'));
        $telefone->addValidator('StringLength', false, array('max' => '50'));
        $this->addElement($telefone);

        // ============================================================================================================
        // Decorators (bootstrap do twitter)
        // ============================================================================================================
        EasyBib_Form_SubFormDecorator::setSubFormDecorator($this);
    }

    public function render(Zend_View_Interface $view = null)
    {
        $id = $this->getElement('id')->getValue();
        $content = '<div class="subform">';
        $content .= '<a id="telefones-' . $id . '" class="close btn" href="#"><span class="icon-trash"></span></a>';
        $content .= parent::render($view);
        $content .= '</div>';
        return $content;
    }

}