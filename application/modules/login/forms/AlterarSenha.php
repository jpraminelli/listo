<?php

class Login_Form_AlterarSenha extends Lib_Form
{

    public function init()
    {
        $this->setOptions(array("class" => "form_login"));

        /*
         * Código
         */
        $element = $this->createElement('hidden', 'codigo');
        $element->removeDecorator('Label');
        $this->addElement($element);

        /*
         * Senha
         */
        $login = $this->createElement('password', 'senha');
        $login->setLabel('Senha')
            ->setAttrib('maxlength', '60')
            ->addValidator('StringLength', true, array(1, 60))
            ->setRequired(true);
        $this->addElement($login);

        /*
         * Confirmar Senha
         */
        $senha = $this->createElement('password', 'confirma_senha');
        $senha->setLabel('Confirme a senha:')
            ->setAttrib('maxlength', '60')
            ->addValidator('StringLength', true, array(1, 60))
            ->setRequired(true)
            ->setIgnore(true)
            ->addValidator('Identical', false, array('token' => 'senha'));
        ;
        $this->addElement($senha);

        /*
         * Submit
         */
        $submit = $this->createElement('Submit', 'Salvar');
        $submit->setLabel('Salvar')
            ->setAttrib('class', 'bt_acessar')
            ->addFilters(array('StringTrim', 'StripTags'));
        $this->addElement($submit);
    }

}
