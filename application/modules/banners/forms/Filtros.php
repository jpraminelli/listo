<?php

class Banners_Form_Filtros extends Zend_Form
{

    public function __construct()
    {
        parent::__construct();
        $this->populate($_GET);
    }

    public function init()
    {
        $this->setOptions(array('method' => 'get', 'id' => get_class($this)));

        

        // ------------------------------------------------------------------------------------------------------------
        // BUSCAR
        // ------------------------------------------------------------------------------------------------------------
        $buscar = $this->createElement('text', 'buscar');
        $buscar->setLabel('Buscar')
                ->setDescription('A busca por palavra-chave age no campo nome.')
                ->setAttrib('class', 'input-block-level');
        $buscar->addFilters(array('StringTrim', 'StripTags'));
        $this->addElement($buscar);

        // ------------------------------------------------------------------------------------------------------------
        // PÁGINA
        // ------------------------------------------------------------------------------------------------------------
        $pagina = $this->createElement('hidden', 'pagina');
        $pagina->addFilters(array('StripTags'));
        $this->addElement($pagina);

        // ------------------------------------------------------------------------------------------------------------
        // PESQUISAR
        // ------------------------------------------------------------------------------------------------------------
        $pesquisar = $this->createElement('submit', 'pesquisar');
        $pesquisar->setLabel('Pesquisar')
                ->addFilters(array('StripTags'))
                ->setAttrib('class', 'btn btn-info')
                ->setIgnore(true);
        $this->addElement($pesquisar);

        // ------------------------------------------------------------------------------------------------------------
        // LIMPAR
        // ------------------------------------------------------------------------------------------------------------
        $limpar = $this->createElement('reset', 'limpar');
        $limpar->setLabel('Limpar')
                ->addFilters(array('StripTags'))
                ->setAttrib('class', 'btn')
                ->setIgnore(true);
        $this->addElement($limpar);

        // ============================================================================================================
        // Decorators (bootstrap do twitter)
        // ============================================================================================================
        EasyBib_Form_Decorator::setFormDecorator($this, EasyBib_Form_Decorator::BOOTSTRAP, 'pesquisar', 'limpar');
    }

}