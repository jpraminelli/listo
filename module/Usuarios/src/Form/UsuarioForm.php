<?php

namespace Usuarios\Form;

use Zend\Form\Form;

class UsuarioForm extends Form
{
    public function __construct()
    {
        parent::__construct('usuario_form');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'validator',
            'type' => 'Shift\Form\Element\Csrf',
        ));
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        $this->add(array(
            'name' => 'nome',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class'  => 'form-control',
                'id'  => 'nome',
                'maxlength'  => 50,
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class'  => 'form-control',
                'id'  => 'nome',
                'maxlength'  => 100,
            ),
        ));
        $this->add(array(
            'name' => 'login',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class'  => 'form-control',
                'id'  => 'nome',
                'maxlength'  => 50,
            ),
        ));
        $this->add(array(
            'name' => 'senha',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'class'  => 'form-control',
                'id'  => 'nome',
                'maxlength'  => 20,
            ),
        ));
        $this->add(array(
            'name' => 'senha2',
            'type' => 'Zend\Form\Element\Password',
            'attributes' => array(
                'class'  => 'form-control',
                'id'  => 'nome',
                'maxlength'  => 20,
            ),
        ));
        $this->add(array(
            'name' => 'visivel',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'id'  => 'visivel',
            ),
        ));
        
        $this->get('visivel')->setValue(true);
        
        $this->add(array(
            'type' => 'Submit',
            'name' => 'salvar'
        ));
    }

    public function isValid()
    {
        // No caso de edição, remove a obrigatoriedade da senha.
        if ($this->data['id']) {
            $this->getInputFilter()->get('senha')->setRequired(false);
            $this->getInputFilter()->get('senha2')->setRequired(false);
        }
        return parent::isValid();
    }
}
