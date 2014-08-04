<?php

class Curriculos_Form_Filtros extends Zend_Form
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
            ->setAttrib('class', 'span2')
            ->addMultiOptions(array(
                '' => 'Todos',
                'true' => 'Ativos',
                'false' => 'Inativos',
            ));
        $this->addElement($status);

        // ------------------------------------------------------------------------------------------------------------
        // PONTUAÇÃO
        // ------------------------------------------------------------------------------------------------------------
        $pontuacao = $this->createElement('select', 'pontuacao');
        $pontuacao->setLabel('Pontuação')
            //    ->setDescription('Permite a seleção de currículos que ainda não tenham uma pontuação definida.')
            ->addFilters(array('StripTags'))
            ->setAttrib('class', 'span2')
            ->addMultiOptions(array(
                '' => 'Todos',
                '1' => 'Com pontuação',
                '0' => 'Sem pontuação'
            ));
        $this->addElement($pontuacao);

        // ------------------------------------------------------------------------------------------------------------
        // DATA DE ATUALIZAÇÃO
        // ------------------------------------------------------------------------------------------------------------
        $data_atualizacao = $this->createElement('text', 'data_atualizacao');
        $data_atualizacao->setLabel('Atualizado a partir de');
        $data_atualizacao->setAttrib('class', 'span2');
        $data_atualizacao->addFilters(array('StringTrim', 'StripTags'));
        $data_atualizacao->setAttrib('maxlength', '10');
        $data_atualizacao->addValidator('StringLength', false, array(10));
        $data_atualizacao->addValidator('Date', false, array('format' => Zend_Date::DAY . '/' . Zend_Date::MONTH . '/' . Zend_Date::YEAR));
        $this->addElement($data_atualizacao);

        // ------------------------------------------------------------------------------------------------------------
        // ÁREA
        // ------------------------------------------------------------------------------------------------------------
        $areaTable = new Curriculos_Model_DbTable_Areas();
        $area = $this->createElement('select', 'area_id');
        $area->setLabel('Área');
        $area->addFilters(array('StripTags'));
        $area->setAttrib('class', 'span3');
        $area->addMultiOptions($areaTable->listaCombo('Todas'));
        $this->addElement($area);

        // ------------------------------------------------------------------------------------------------------------
        // CARGO
        // ------------------------------------------------------------------------------------------------------------
        $cargo = $this->createElement('select', 'cargo_id');
        $cargo->setLabel('Cargo');
        $cargo->addFilters(array('StripTags'));
        $cargo->setAttrib('class', 'span3');
        $cargo->addMultiOptions(array('' => 'Todos'));
        $this->addElement($cargo);

        // ------------------------------------------------------------------------------------------------------------
        // ESTADO
        // ------------------------------------------------------------------------------------------------------------
        $estadosTable = new Geo_Model_DbTable_Estados();
        $estado = $this->createElement('select', 'estado_id');
        $estado->setLabel('Estado');
        $estado->addFilters(array('StripTags'));
        $estado->setAttrib('class', 'span3');
        $estado->addMultiOptions($estadosTable->listaCombo('Todos'));
        $this->addElement($estado);

        // ------------------------------------------------------------------------------------------------------------
        // CIDADE
        // ------------------------------------------------------------------------------------------------------------
        $cidade = $this->createElement('select', 'cidade_id');
        $cidade->setLabel('Cidade');
        $cidade->addFilters(array('StripTags'));
        $cidade->setAttrib('class', 'span3');
        $cidade->addMultiOptions(array('' => 'Todas'));
        $this->addElement($cidade);

        // ------------------------------------------------------------------------------------------------------------
        // BUSCAR
        // ------------------------------------------------------------------------------------------------------------
        $buscar = $this->createElement('text', 'buscar');
        $buscar->setLabel('Buscar');
        $buscar->setAttrib('class', 'span3');
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

    public function populate(array $values)
    {
        if ((isset($values['area_id'])) && (is_numeric($values['area_id']))) {
            $cargosTable = new Curriculos_Model_DbTable_Cargos();
            $cargos = $cargosTable->listaCombo($values['area_id'], 'Todos');
            $cargo = $this->getElement('cargo_id');
            $cargo->setOptions(array('multiOptions' => $cargos));
        }
        if ((isset($values['estado_id'])) && ($values['estado_id'])) {
            $cidadesTable = new Geo_Model_DbTable_Cidades();
            $cidades = $cidadesTable->listaCombo($values['estado_id'], 'Todas');
            $cidade = $this->getElement('cidade_id');
            $cidade->setOptions(array('multiOptions' => $cidades));
        }
        parent::populate($values);
    }

}
