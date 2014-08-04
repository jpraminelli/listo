<?php

class Usuarios_Form_Usuario extends Lib_Form
{

    protected $_attribs = array(
        'id' => 'Usuarios_Form_Usuario',
        'class' => 'form-horizontal'
    );

    public function init()
    {
//        $this->setOptions(array('id' => get_class($this), ));
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
                ->setRequired(true)
                ->setAttrib('class', 'span3')
                ->setAttrib('maxlength', '50')
                ->setAttrib('placeholder', 'Nome')
                ->setDescription('Nome completo do usuário. Ex: João da Silva')
                ->addFilter('Null')
                ->addFilters(array('StringTrim', 'StripTags'))
                ->addValidator('NotEmpty', true)
                ->addValidator('StringLength', false, array('max' => 50));
        $this->addElement($element);

        // ------------------------------------------------------------------------------------------------------------
        // E-MAIL
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('text', 'email');
        $element->setLabel('E-mail')
                ->setRequired(true)
                ->setAttrib('class', 'span3')
                ->setAttrib('maxlength', '100')
                ->setAttrib('placeholder', 'E-mail')
                ->addFilters(array('StringTrim', 'StripTags'))
                ->addValidator('NotEmpty', true)
                ->addValidator('EmailAddress', true)
                ->addValidator('StringLength', false, array('max' => 100));
        $this->addElement($element);

        // ------------------------------------------------------------------------------------------------------------
        // SENHA
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('password', 'senha');
        $element->setLabel('Senha')
                ->setAttrib('class', 'span2')
                ->setAttrib('placeholder', 'Senha');
        if (!empty($this->_data['id'])) {
            $element->setDescription('Caso não queira alterar a senha, deixe o campo em branco.');
        } else {
            $element->setRequired(true)
                    ->addValidator('NotEmpty');
        }
        $this->addElement($element);

        // ------------------------------------------------------------------------------------------------------------
        // CONFIRMAÇÃO DE SENHA
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('password', 'confirmar_senha');
        $element->setLabel('Confirme a senha')
                ->setAttrib('class', 'span2')
                ->setAttrib('placeholder', 'Confirme a senha')
                ->setIgnore(true)
                ->addValidator('Identical', false, array('token' => 'senha'));
        if (empty($this->_data) || !empty($_POST['senha'])) {
            $element->setRequired(true);
        }
        $this->addElement($element);

        // ------------------------------------------------------------------------------------------------------------
        // ATIVO
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('checkbox', 'ativo');
        $element->setLabel('Ativo')
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