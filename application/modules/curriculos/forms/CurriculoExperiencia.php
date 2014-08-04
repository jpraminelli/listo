<?php

class Curriculos_Form_CurriculoExperiencia extends Lib_Form_SubForm
{

    public function init()
    {

        if ($this->_data && isset($this->_data['id'])) {
            $recid = $this->_data['id'];
        } else {
            $recid = 'new_' . time();
        }
        $this->setName("experiencias_$recid");
        $this->setElementsBelongTo("experiencias[$recid]");

        // ------------------------------------------------------------------------------------------------------------
        // id (hidden)
        // ------------------------------------------------------------------------------------------------------------
        $id = $this->createElement('hidden', 'id');
        $id->removeDecorator('label');
        $id->setValue($recid);
        $this->addElement($id);

        // ------------------------------------------------------------------------------------------------------------
        // empresa
        // ------------------------------------------------------------------------------------------------------------
        $empresa = $this->createElement('text', 'empresa');
        $empresa->setLabel('Empresa');
        $empresa->setAttrib('class', 'span3');
        $empresa->setRequired(true);
        $empresa->addFilters(array('StringTrim', 'StripTags'));
        $empresa->setAttrib('maxlength', '50');
        $empresa->addValidator('StringLength', false, array('max' => '50'));
        $this->addElement($empresa);

        // ------------------------------------------------------------------------------------------------------------
        // cargo
        // ------------------------------------------------------------------------------------------------------------
        $cargo = $this->createElement('text', 'cargo');
        $cargo->setLabel('Cargo');
        $cargo->setAttrib('class', 'span2');
        $cargo->setRequired(true);
        $cargo->addFilters(array('StringTrim', 'StripTags'));
        $cargo->setAttrib('maxlength', '50');
        $cargo->addValidator('StringLength', false, array('max' => '50'));
        $this->addElement($cargo);

        // ------------------------------------------------------------------------------------------------------------
        // tempo de trabalho
        // ------------------------------------------------------------------------------------------------------------
        $tempo_trabalho = $this->createElement('text', 'tempo_trabalho');
        $tempo_trabalho->setLabel('Tempo de trabalho');
        $tempo_trabalho->setAttrib('class', 'span1');
        $tempo_trabalho->addFilters(array('StringTrim', 'StripTags'));
        $tempo_trabalho->setAttrib('maxlength', '50');
        $tempo_trabalho->addValidator('StringLength', false, array('max' => '50'));
        $this->addElement($tempo_trabalho);

        // ------------------------------------------------------------------------------------------------------------
        // pessoa para contato
        // ------------------------------------------------------------------------------------------------------------
        $pessoa_contato = $this->createElement('text', 'contato_pessoa');
        $pessoa_contato->setLabel('Pessoa para contato');
        $pessoa_contato->setAttrib('class', 'span4');
        $pessoa_contato->addFilters(array('StringTrim', 'StripTags'));
        $pessoa_contato->setAttrib('maxlength', '50');
        $pessoa_contato->addValidator('StringLength', false, array('max' => '50'));
        $this->addElement($pessoa_contato);

        // ------------------------------------------------------------------------------------------------------------
        // telefone
        // ------------------------------------------------------------------------------------------------------------
        $telefone = $this->createElement('text', 'contato_telefone');
        $telefone->setLabel('Telefone');
        $telefone->setAttrib('class', 'span2 _contato_telefone');
        $telefone->addFilters(array('StringTrim', 'StripTags'));
        $telefone->setAttrib('maxlength', '50');
        $telefone->addValidator('StringLength', false, array('max' => '50'));
        $this->addElement($telefone);

        // ------------------------------------------------------------------------------------------------------------
        // observações
        // ------------------------------------------------------------------------------------------------------------
        $observacoes = $this->createElement('textarea', 'resumo_atividades');
        $observacoes->setLabel('Resumo das atividades');
        $observacoes->setAttrib('class', 'span6');
        $observacoes->setAttrib('rows', '5');
        $observacoes->addFilters(array('StringTrim', 'StripTags'));
        $observacoes->addValidator('StringLength', false, array('max' => '32000'));
        $this->addElement($observacoes);

        // ============================================================================================================
        // Decorators (bootstrap do twitter)
        // ============================================================================================================
        EasyBib_Form_SubFormDecorator::setSubFormDecorator($this);
    }

    public function render(Zend_View_Interface $view = null)
    {
        $id = $this->getElement('id')->getValue();
        $content = '<div class="subform">';
        $content .= '<a id="experiencias-' . $id . '" class="close btn" href="#"><span class="icon-trash"></span></a>';
        $content .= parent::render($view);
        $content .= '</div>';
        return $content;
    }

}