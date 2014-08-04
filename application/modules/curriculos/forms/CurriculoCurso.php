<?php

class Curriculos_Form_CurriculoCurso extends Lib_Form_SubForm
{

    public function init()
    {
        $hash = $this->getHash();

        $this->setName("cursos_{$hash}");
        $this->setElementsBelongTo("cursos[{$hash}]");

        // ------------------------------------------------------------------------------------------------------------
        // id (hidden)
        // ------------------------------------------------------------------------------------------------------------
        $id = $this->createElement('hidden', 'id');
        $id->setValue($hash);
        $this->addElement($id);

        // ------------------------------------------------------------------------------------------------------------
        // instituição
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('text', 'instituicao');
        $element->setLabel('Instituição')
                ->setRequired(true)
                ->setAttrib('maxlength', '255')
                ->setAttrib('class', 'span4')
                ->setDecorators(array('ViewHelper'))
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => 255));
        $this->addelement($element);

        // ------------------------------------------------------------------------------------------------------------
        // duração
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('text', 'duracao');
        $element->setLabel('Duração')
                ->setRequired(true)
                ->setAttrib('maxlength', '50')
                ->setAttrib('style', 'width:80px;')
                ->setDecorators(array('ViewHelper'))
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => 50));
        $this->addelement($element);

        // ------------------------------------------------------------------------------------------------------------
        // curso
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('text', 'curso');
        $element->setLabel('Curso')
                ->setRequired(true)
                ->setAttrib('maxlength', '255')
                ->setAttrib('class', 'span3')
                ->setDecorators(array('ViewHelper'))
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => 255));
        $this->addelement($element);

        // ============================================================================================================
        // Decorators (bootstrap do twitter)
        // ============================================================================================================
        EasyBib_Form_SubFormDecorator::setSubFormDecorator($this);
    }

    private function getHash()
    {
        if ($this->_data && isset($this->_data['id'])) {
            $hash = $this->_data['id'];
        } else {
            $hash = 'new_' . time();
        }

        return $hash;
    }

    public function render(Zend_View_Interface $view = null)
    {
        $id = $this->getElement('id')->getValue();
        $content = '<div class="subform">';
        $content .= '<a id="cursos-' . $id . '" class="close btn" href="#"><span class="icon-trash"></span></a>';
        $content .= parent::render($view);
        $content .= '</div>';
        return $content;
    }

}