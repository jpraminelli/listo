<?php

class Curriculos_Form_Area extends Lib_Form
{

    public function init()
    {
        $this->setOptions(array('id' => get_class($this), 'class' => 'form-horizontal'));

        // ------------------------------------------------------------------------------------------------------------
        // ID
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('hidden', 'id');
        $element->removeDecorator('Label');
        $this->addElement($element);

        // ------------------------------------------------------------------------------------------------------------
        // NOME
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('text', 'nome');
        $element->setLabel('Nome')
            ->setAttrib('class', 'span3')
            ->setAttrib('maxlength', '50')
            ->setRequired(true)
            ->addValidator('NotEmpty', true)
            ->addValidator('StringLength', false, array('max' => 50))
            ->addFilters(array('StringTrim', 'StripTags'));
        $this->addElement($element);

        // ------------------------------------------------------------------------------------------------------------
        // ATIVA
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('checkbox', 'ativa');
        $element->setLabel('Ativa')
            ->setValue('1');
        $this->addElement($element);

        // ------------------------------------------------------------------------------------------------------------
        // BOTÕES
        // ------------------------------------------------------------------------------------------------------------
        $this->addButtons();

        // ============================================================================================================
        // Decorators (bootstrap do twitter)
        // ============================================================================================================
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'Salvar', 'Cancelar');
    }

}