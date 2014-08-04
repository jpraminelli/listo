<?php

class Curriculos_Form_FiltroCargos extends Lib_Form
{

    public function init()
    {
        $this->setOptions(array('method' => 'get', 'id' => get_class($this)));

        // ------------------------------------------------------------------------------------------------------------
        // STATUS
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('select', 'status');
        $element->setLabel('Status')
            ->setAttrib('class', 'input-medium')
            ->addMultiOptions(array(
                'todos' => 'Todos',
                'true' => 'Ativos',
                'false' => 'Inativos'
            ));
        $this->addElement($element);

        // ------------------------------------------------------------------------------------------------------------
        // ÁREAS
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('select', 'area');
        $element->setLabel('Áreas')
            ->setAttrib('class', 'input-medium')
            ->addMultiOptions(array('todas' => 'Todas') + Curriculos_Model_DbTable_Areas::getFetchPairs(array('id', 'nome'), null, 'nome ASC'));
        $this->addElement($element);

        // ------------------------------------------------------------------------------------------------------------
        // BUSCAR
        // ------------------------------------------------------------------------------------------------------------
        $element = $this->createElement('text', 'buscar');
        $element->setLabel('Buscar')
            ->setAttrib('class', 'input-medium')
            ->setAttrib('maxlength', '20')
            ->addFilters(array('StringTrim', 'StripTags'))
            ->addValidator('StringLength', false, array('max' => 20));
        $this->addElement($element);

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