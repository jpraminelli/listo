<?php

namespace Noticias\Form;

use Zend\Form\Form;

class NoticiaSearchForm extends Form
{
    public function __construct()
    {
        parent::__construct('noticia_search_form');

        $this->add(array(
            'name' => 'por'
        ));
        $this->add(array(
            'name' => 'visivel'
        ));
    }
}
