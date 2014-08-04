<?php

class Curriculos_Form_CurriculoNota extends Lib_Form_SubForm
{

    public function init()
    {
        if ($this->_data && isset($this->_data['id'])) {
            $recid = $this->_data['id'];
        } else {
            $recid = 'new_' . time();
        }
        $this->setName("notas_$recid");
        $this->setElementsBelongTo("notas[$recid]");

        // ------------------------------------------------------------------------------------------------------------
        // id (hidden)
        // ------------------------------------------------------------------------------------------------------------
        $id = $this->createElement('hidden', 'id');
        $id->removeDecorator('label');
        $id->setValue($recid);
        $this->addElement($id);

        // ------------------------------------------------------------------------------------------------------------
        // nota
        // ------------------------------------------------------------------------------------------------------------
        $texto = $this->createElement('textarea', 'texto');
        $texto->setLabel('Texto');
        $texto->setAttrib('class', 'span3');
        $texto->setAttrib('maxlength', '32000');
        $texto->setAttrib('rows', '5');
        $texto->setRequired(true);
        $texto->addFilters(array('StringTrim', 'StripTags'));
        $texto->addValidator('StringLength', false, array('max' => '32000'));
        $this->addElement($texto);

        // ============================================================================================================
        // Decorators (bootstrap do twitter)
        // ============================================================================================================
        EasyBib_Form_SubFormDecorator::setSubFormDecorator($this);
    }

    public function render(Zend_View_Interface $view = null)
    {
        $id = $this->getElement('id')->getValue();
        $content = '<div class="subform">';
        $content .= '<a id="notas-' . $id . '" class="close btn" href="#"><span class="icon-trash"></span></a>';
        $content .= parent::render($view);
        $content .= '</div>';
        return $content;
    }

}