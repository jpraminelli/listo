<?php

class Curriculos_Form_FiltroListas extends Lib_Form
{

    public function init()
    {
        $this->setOptions(array('method' => 'get', 'id' => get_class($this)));

        // ------------------------------------------------------------------------------------------------------------
        // DATA
        // ------------------------------------------------------------------------------------------------------------
        $data = $this->createElement('text', 'data');
        $data->setLabel('Data')
            ->setDescription('Busca as listas que estão (ou estavam) vigentes em uma determinada data.')
            ->setAttrib('class', 'input-medium')
            ->setAttrib('maxlength', '10')
            ->setAttrib('alt', 'date')
            ->addValidator('StringLength', false, array('max' => 10))
            ->addValidator('Date', false, array('format' => Zend_Date::DAY . '/' . Zend_Date::MONTH . '/' . Zend_Date::YEAR));
        $this->addElement($data);

        // ------------------------------------------------------------------------------------------------------------
        // BUSCAR
        // ------------------------------------------------------------------------------------------------------------
        $buscar = $this->createElement('text', 'buscar');
        $buscar->setLabel('Buscar');
        $buscar->setAttrib('class', 'input-medium');
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