<?php

class Login_Form_Login extends Lib_Form {

    public function init() {
        $this->setOptions(array("class" => "form_login"));
        $this->setAction('admin');
        $this->setAttrib('role', 'form');

        /*
         * Login
         */
        $login = $this->createElement('Text', 'login');
        $login->setLabel('Login:')
                ->setAttrib('maxlength', '60')
                ->addValidator('StringLength', true, array(1, 60))
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('HtmlTag')
                ->removeDecorator('Label')
                ->setAttrib('class', 'form-control')
                ->setRequired(true);
        $this->addElement($login);

        /*
         * Senha
         */
        $senha = $this->createElement('Password', 'senha');
        $senha->setLabel('Senha:')
                ->setAttrib('maxlength', '60')
                ->addValidator('StringLength', true, array(1, 60))
                ->removeDecorator('DtDdWrapper')
                ->removeDecorator('HtmlTag')
                ->removeDecorator('Label')
                ->setAttrib('class', 'form-control')
                ->setRequired(true);
        $this->addElement($senha);

        /*
         * Esqueci
         */
        $esqueci = $this->createElement('button', 'Esqueci');
        $esqueci->setLabel('[+] Esqueci minha senha')
                ->setAttrib('class', 'bt_esqueci_senha');
        $this->addElement($esqueci);

        /*
         * Submit
         */
        $submit = $this->createElement('Submit', 'Login');
        $submit->setLabel('Login')
                ->setAttrib('class', 'bt_acessar')
                ->addFilters(array('StringTrim', 'StripTags'));
        $this->addElement($submit);
    }

}
