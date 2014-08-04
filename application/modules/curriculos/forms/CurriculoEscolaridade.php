<?php

class Curriculos_Form_CurriculoEscolaridade extends Lib_Form_SubForm
{

    public function init()
    {
        $hash = $this->getHash();

        $this->setName("escolaridades_{$hash}");
        $this->setElementsBelongTo("escolaridades[{$hash}]");

        /*
         * id (hidden)
         */
        $id = $this->createElement('hidden', 'id');
        $id->setValue($hash);
        $this->addElement($id);

        /*
         * Escolaridade
         */
        $element = $this->createElement('select', 'escolaridade_tipo_id');
        $element->setLabel('Tipo de curso')
                ->setRequired(true)
                ->addValidator('NotEmpty', true)
                ->addMultiOptions(array('' => 'Selecione...') + TrabalheConosco_Model_DbTable_EscolaridadesTipos::getFetchPairs(array('id', 'nome'), null, 'nome ASC'));
        $this->addElement($element);

        /*
         * Instituição
         */
        $element = $this->createElement('text', 'instituicao');
        $element->setLabel('Instituição')
                ->setRequired(true)
                ->setAttrib('maxlength', '255')
                ->setAttrib('class', 'span4')
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => 255));
        $this->addelement($element);

        /*
         * Duração
         */
        $element = $this->createElement('text', 'duracao');
        $element->setLabel('Duração')
                ->setRequired(true)
                ->setAttrib('maxlength', '50')
                ->setAttrib('class', 'span1')
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => 50));
        $this->addelement($element);

        /*
         * Curso
         */
        $element = $this->createElement('text', 'curso');
        $element->setLabel('Curso')
                ->setRequired(true)
                ->setAttrib('maxlength', '255')
//                ->setAttrib('style', 'width:232px;')
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
        $content = '<div class="subform subform_escolaridades">';
        $content .= '<a id="escolaridades-' . $id . '" class="close btn" href="#"><span class="icon-trash"></span></a>';
        $content .= parent::render($view);
        $content .= '</div>';
        return $content;
    }

}