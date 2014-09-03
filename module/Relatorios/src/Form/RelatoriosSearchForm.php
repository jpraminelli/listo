<?php

namespace Relatorios\Form;

use Zend\Form\Form;

class RelatoriosSearchForm extends Form
{
    public function __construct()
    {
        parent::__construct('relatorios_search_form');

        $this->add(array(
            'name' => 'por'
        ));
        $this->add(array(
            'name' => 'visivel'
        ));
    }
}
