<?php

namespace Usuarios\Form;

use Zend\Form\Form;

class UsuarioSearchForm extends Form
{
    public function __construct()
    {
        parent::__construct('usuario_search_form');

        $this->add(array(
            'name' => 'por'
        ));
        $this->add(array(
            'name' => 'ponto'
        ));
    }
}
