<?php

namespace Noticias\Form;

use Zend\Form\Form;

class NoticiaForm extends Form
{

    public function __construct()
    {
        parent::__construct('noticia_form');
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
            'name' => 'titulo',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class'  => 'form-control',
                'id'  => 'nome',
                'maxlength'  => 100,
            ),
        ));
        $this->add(array(
            'name' => 'chamada',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class'  => 'form-control',
                'id'  => 'chamada',
                'rows'  => 4,
            ),
        ));
        $this->add(array(
            'name' => 'descricao',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class'  => 'form-control',
                'id'  => 'descricao',
                'rows'  => 10,
            ),
        ));
        
        $this->add(array(
            'name' => 'visivel',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'id'  => 'visivel',
            ),
        ));
        
        $this->add(array(
            'type' => 'Submit',
            'name' => 'salvar'
        ));
    }

}
