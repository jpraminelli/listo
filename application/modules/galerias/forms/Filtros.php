<?php

class Galerias_Form_Filtros extends Zend_Form
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
        // STATUS
        // ------------------------------------------------------------------------------------------------------------
        $status = $this->createElement('select', 'status');
        $status->setLabel('Status')
                ->addFilters(array('StripTags'))
                ->setAttrib('class', 'input-block-level')
                ->addMultiOptions(array(
                    'todos' => 'Todos',
                    'true' => 'Ativos',
                    'false' => 'Inativos',
                ))
                ->setValue('true');
        $this->addElement($status);

        // ------------------------------------------------------------------------------------------------------------
        // BUSCAR
        // ------------------------------------------------------------------------------------------------------------
        $buscar = $this->createElement('text', 'buscar');
        $buscar->setLabel('Buscar')
                ->setDescription('As buscas por palavras chave agem nos campos nome e e-mail.')
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