<?php

namespace Usuarios\Form;

use Zend\Form\Form;

class LoginForm extends Form
{

    public function __construct()
    {
        parent::__construct('login_form');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'type' => 'Usuarios\Form\LoginFieldset',
            'options' => array(
                'use_as_base_fieldset' => true,
            )
        ));
        $this->add(array(
            'name' => 'validator',
            'type' => 'Shift\Form\Element\Csrf',
        ));
    }

}
